import socket
import threading

def handle_client(client_socket, client_address):
    """클라이언트와 통신을 처리하는 함수"""
    print(f"클라이언트 연결됨: {client_address}")
    try:
        while True:
            message = client_socket.recv(1024).decode('utf-8')
            if not message:
                print(f"클라이언트 연결 종료: {client_address}")
                break
            print(f"[{client_address}] {message}")
    except Exception as e:
        print(f"클라이언트 처리 중 오류 발생: {e}")
    finally:
        client_socket.close()

def run_server():
    host = '210.101.236.185'  # 서버 호스트 주소
    port = 3333        # 사용할 포트 번호

    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.bind((host, port))
    server_socket.listen(5)

    print(f"서버가 {host}:{port}에서 대기 중입니다...")
    try:
        while True:
            client_socket, client_address = server_socket.accept()
            # 각 클라이언트를 독립적으로 처리하기 위해 스레드 생성
            client_thread = threading.Thread(target=handle_client, args=(client_socket, client_address))
            client_thread.daemon = True
            client_thread.start()
    except KeyboardInterrupt:
        print("서버가 종료되었습니다.")
    finally:
        server_socket.close()

if __name__ == "__main__":
    run_server()
