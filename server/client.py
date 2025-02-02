import socket

def run_client():
    host = '210.101.236.160'  # 서버 호스트 주소
    port =     # 서버 포트 번호

    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client_socket.connect((host, port))
    print("서버에 연결되었습니다. 메시지를 입력하세요 (종료하려면 'exit' 입력).")

    try:
        while True:
            message = input(">>> ")
            if message.lower() == 'exit':
                print("서버와의 연결을 종료합니다.")
                break
            client_socket.sendall(message.encode('utf-8'))
    except Exception as e:
        print(f"오류 발생: {e}")
    finally:
        client_socket.close()
        print("클라이언트가 종료되었습니다.")

if __name__ == "__main__":
    run_client()