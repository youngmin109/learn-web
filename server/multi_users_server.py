import socket
import threading

HOST = "127.0.0.1"
PORT = 12345

client_list = [] # 연결된 클라이언트 목록 # 공유자원
client_list_lock = threading.Lock() # 스레드 동기화를 위한 Lock

# 클라이언트 핸들러 함수
def handler_client(client_socket: socket.socket, client_addr):
    """ 클라이언트와 메시지를 주고받고, 연결이 종료되면 목록에서 제거하는 함수"""
    
    
    try:
        while True:
            rcvd_msg = client_socket.recv(1024).decode('utf-8')
            
            if not rcvd_msg:
                break
            
            rcvd_msg = f"{client_addr}: {rcvd_msg}"
            
            # Lock이 없으면 하나의 스레드가 리스트에서 클라이언트를 제거하는 중에, 동시에 다른 스레드가
            # 리스트를 순회할 경우, 리스트 크기가 변경되어 IndexError가 발생할 수 있다.
            with client_list_lock: # 멀티스레드 환경에서 리스트 동기화
                for socket_item in client_list:
                    if socket_item != client_socket: # 본인에게는 메시지를 보내지 않음
                        try:
                            socket_item.sendall(rcvd_msg.encode("utf-8"))
                        except: # 비정상 종료된 클라이언트 제거
                            client_list.remove(socket_item)
                            socket_item.close()
    except Exception as e: # 클라이언트가 예기치 않은 오류가 발생했을 때 서버강제종료되지 않도록 예외처리리
        print(f"[ERROR] Client {client_addr} error: {e}")
    
    # 클라이언트 목록에서 제거
    finally:
        # with는 context manager를 활용하는 문법으로 리소스(파일,락, 소켓 등)를 안전하게 열고 닫도록 관리
        with client_list_lock: # 락을 사용하여 리스트 안전하게 수정
            if client_socket in client_list:
                client_list.remove(client_socket) # with를 나오면 안전하게 리소스를 반납
        #  자원을 정리
        client_socket.close()
        print(f"Client {client_addr} disconnected")

# 서버 소켓 생성 및 설정
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM) # IPv4, TCP 사용
server_socket.bind((HOST,PORT)) 
server_socket.listen(5) # 최대 5개 연결 대기

print(f"Server listening on {HOST}:{PORT}")

try:
    while True:
        print(f"Connected clients: {len(client_list)}")
        
        client_socket, client_addr = server_socket.accept() # 블로킹
        print(f"Client connected: {client_addr}")
        
        with client_list_lock: # 클라이언트 목록에 추가
            client_list.append(client_socket)
            
            # 클라이언트 전용 스레드 실행
            client_thread = threading.Thread(target=handler_client, arg=(client_socket, client_addr), daemon=True)
            client_thread.start()
            
except KeyboardInterrupt:
    print("\n[INFO] Server shutting down..")

finally:
    with client_list_lock:
        for client_socket in client_list:
            client_socket.close()
            
    server_socket.close()
    print("[INFO] Server closed")