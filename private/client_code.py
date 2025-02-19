클라이언트

import socket
import threading
import json

# 서버 주소 및 포트 설정
SERVER_HOST = "127.0.0.1"
SERVER_PORT = 12345

def send_message(sock, username):
    """사용자로부터 입력을 받아 서버에 메시지를 전송하는 함수"""
    while True:
        try:
            message = input(f"[{username}] ")  # 사용자 입력 받기
            if message.lower() == "exit":
                # 종료 메시지 전송 후 루프 종료
                sock.sendall(json.dumps({"type": "exit"}).encode("utf-8"))
                break
            
            if message.startswith("/pm"):
                # 귓속말 메시지 처리 ("/pm 닉네임 메시지")
                parts = message.split(" ", 2)
                if len(parts) < 3:
                    print("[사용법] /pm 닉네임 메시지")
                    continue
                
                private_message = json.dumps({
                    "type": "private",
                    "recipient": parts[1],
                    "content": parts[2]
                })
                sock.sendall(private_message.encode("utf-8"))
                print(f"[나 -> {parts[1]}] {parts[2]}")
            else:
                # 일반 메시지(전체 채팅) 전송
                broadcast_message = json.dumps({
                    "type": "broadcast",
                    "content": message
                })
                sock.sendall(broadcast_message.encode("utf-8"))
        except Exception as e:
            print(f"[송신 오류] {e}")
            break
    sock.close()

def receive_message(sock, username):
    """서버로부터 수신된 메시지를 출력하는 함수"""
    while True:
        try:
            received_data = sock.recv(1024).decode("utf-8")
            if not received_data:
                break  # 연결 종료

            try:
                message_data = json.loads(received_data)
                message_type = message_data.get("type")
                content = message_data.get("content")
                sender = message_data.get("from")
                
                # 메시지 유형별 출력 형식 지정
                if message_type == "notice":
                    print(f"📢 {content}")  # 공지 메시지
                elif message_type == "private":
                    print(f"💌 [귓속말] ({sender}): {content}")  # 귓속말
                elif message_type == "message":
                    print(f"({sender}): {content}")  # 일반 채팅 메시지
                else:
                    print(f"🚫 알 수 없는 메시지 유형: {content}")

                # 입력 프롬프트 유지
                print(f"\r[{username}] ", end="")
            except json.JSONDecodeError:
                print("[JSON 오류] 수신된 데이터 파싱 실패")
        except Exception as e:
            print(f"[수신 오류] {e}")
            break
    
    print("[연결 종료] 서버와의 연결이 끊어졌습니다.")
    sock.close()

# 클라이언트 실행
try:
    # 서버에 연결
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client_socket.connect((SERVER_HOST, SERVER_PORT))
    
    # 서버로부터 닉네임 요청 메시지 수신
    server_response = client_socket.recv(1024).decode("utf-8")
    response_data = json.loads(server_response)
    
    if response_data.get("type") == "request":
        # 닉네임 입력 후 서버에 전송
        username = input("닉네임을 입력하세요: ").strip()
        client_socket.sendall(json.dumps({"type": "nickname", "content": username}).encode("utf-8"))
        
        # 서버 응답 확인
        server_response = client_socket.recv(1024).decode("utf-8")
        response_data = json.loads(server_response)
        
        if response_data.get("type") == "success":
            # 메시지 송신 및 수신을 위한 스레드 실행
            send_thread = threading.Thread(target=send_message, args=(client_socket, username), daemon=True)
            receive_thread = threading.Thread(target=receive_message, args=(client_socket, username), daemon=True)
            
            send_thread.start()
            receive_thread.start()
            
            # 수신 스레드가 종료될 때까지 대기
            receive_thread.join()
        else:
            # 닉네임 중복 시 오류 메시지 출력
            print(f"🚫 닉네임 중복: {response_data['content']}")
    else:
        print(f"🚫 서버 응답 오류: {response_data['content']}")
except Exception as e:
    print(f"[클라이언트 오류] {e}")
except KeyboardInterrupt:
    # Ctrl + C 입력 시 종료
    pass
finally:
    client_socket.close()
    print("[클라이언트 종료]")
