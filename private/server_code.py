import socket
import threading
import json

# 연결된 클라이언트 목록 (닉네임 -> 소켓)
clients = {}

def handle_client(client_socket, client_address, nickname):
    """클라이언트와 메시지 송수신을 처리하는 함수"""
    print(f"[연결됨] {nickname}({client_address})")

    # 입장 알림 브로드캐스트
    broadcast(json.dumps({"type": "notice", "content": f"{nickname}님이 입장했습니다."}), None)

    try:
        while True:
            # 클라이언트로부터 메시지 수신
            received_data = client_socket.recv(1024).decode('utf-8')
            if not received_data:
                break  # 연결 종료

            try:
                message_data = json.loads(received_data)
            except json.JSONDecodeError:
                print(f"[오류] {nickname}({client_address}): JSON 파싱 실패")
                continue

            message_type = message_data.get("type")
            content = message_data.get("content")
            recipient = message_data.get("recipient")

            if message_type == "private":
                # 귓속말 처리
                if recipient in clients:
                    private_message = json.dumps({
                        "type": "private",
                        "from": nickname,
                        "content": content
                    })
                    print(private_message)
                    clients[recipient].send(private_message.encode('utf-8'))

                    # 송신자에게 전송 확인 메시지 반환
                    client_socket.send(json.dumps({
                        "type": "private",
                        "content": f"[나 -> {recipient}] {content}"
                    }).encode('utf-8'))
                else:
                    # 귓속말 대상이 없을 경우 오류 메시지 전송
                    client_socket.send(json.dumps({
                        "type": "error",
                        "content": f"닉네임 '{recipient}'을 찾을 수 없습니다."
                    }).encode('utf-8'))
            elif message_type == "broadcast":
                # 모든 사용자에게 메시지 전송
                broadcast(json.dumps({
                    "type": "message",
                    "from": nickname,
                    "content": content
                }), nickname)
    
    except Exception as e:
        print(f"[에러] {nickname}({client_address}): {e}")
    
    finally:
        # 클라이언트 연결 종료 및 목록에서 삭제
        client_socket.close()
        if nickname in clients:
            del clients[nickname]

        # 퇴장 알림 브로드캐스트
        broadcast(json.dumps({
            "type": "notice",
            "content": f"{nickname}님이 퇴장했습니다."
        }), None)

        print(f"[연결 종료] {nickname}({client_address})")


def broadcast(message, exclude_nickname=None):
    """모든 클라이언트에게 메시지를 전송 (특정 닉네임 제외)"""
    for client_nickname, client_socket in list(clients.items()):
        if client_nickname != exclude_nickname:
            try:
                client_socket.send(message.encode('utf-8'))
            except:
                # 전송 실패 시 클라이언트 제거
                client_socket.close()
                del clients[client_nickname]


def accept_connections(server_socket):
    """클라이언트 연결을 수락하고 닉네임을 등록, 클라이언트와 통신을 위한 쓰레드 실행"""   
    while True:
        try:
            # 클라이언트 연결 수락
            client_socket, client_address = server_socket.accept()
            
            # 닉네임 요청 메시지 전송
            client_socket.send(json.dumps({"type": "request", "content": "닉네임을 입력해주세요:"}).encode('utf-8'))
            
            # 닉네임 수신 및 JSON 파싱
            received_data = client_socket.recv(1024).decode('utf-8')
            try:
                nickname = json.loads(received_data).get('content')
            except json.JSONDecodeError:
                print(f"[닉네임 오류] {client_address}: JSON 파싱 실패")
                client_socket.close()
                continue

            # 닉네임 중복 확인
            if nickname in clients:
                client_socket.send(json.dumps({"type": "error", "content": "이미 사용 중인 닉네임입니다."}).encode('utf-8'))
                client_socket.close()
            else:
                # 닉네임 등록 및 접속 승인
                clients[nickname] = client_socket
                client_socket.send(json.dumps({"type": "success", "content": f"'{nickname}'으로 접속되었습니다."}).encode('utf-8'))

                # 새로운 스레드에서 클라이언트 메시지 처리
                client_thread = threading.Thread(
                    target=handle_client, args=(client_socket, client_address, nickname),
                    daemon=True
                )
                client_thread.start()

        except Exception as e:
            print(f"[클라이언트 처리 오류] {e}")
            client_socket.close()


# 서버 설정
server_ip = '127.0.0.1'
server_port = 12345

try:
    # TCP 소켓 생성 및 바인딩
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.bind((server_ip, server_port))
    server_socket.listen(5)
except Exception as e:
    print(f"[서버 초기화 오류] {e}")
else:
    print(f"[서버 시작] {server_ip}:{server_port}")

    # 클라이언트 연결 수락 스레드 실행
    accept_thread = threading.Thread(target=accept_connections, args=(server_socket,))
    accept_thread.start()
    
    # 메인 스레드에서 키보드 입력 감지 (Ctrl+C 처리)
    while True:
        try:
            input("서버를 종료하려면 'Ctrl+C'를 입력하세요: ")
        except KeyboardInterrupt:
            break  # Ctrl+C 감지 시 종료
finally:
    # 서버 종료 처리
    print("\n[서버 종료 중...]")
    server_socket.close()  # 서버 소켓 닫기

