import socket
import threading

HOST = "210.101.236.180"
PORT = 5500

# 소켓 생성
# IPv4 주소 체계, TCP 기반의 연결형 통신
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# 서버와 연결
# 서버가 accept()를 호출할 때까지 클라이언트는 블로킹 상태가됨
client_socket.connect((HOST,PORT))

# 전역 변수
is_active = [True]

# 데이터 전송 스레드드
def handler_tx():
    while is_active[0]:  # 프로그램이 실행 중이면 계속 반복
        send_msg = input("Text : ")  # 사용자 입력 대기 (blocking)

        if send_msg.lower() == "exit":
            client_socket.close()  # 소켓 닫기 (연결 종료)
            is_active[0] = False  # 다른 스레드도 종료되도록 설정
            break
        # sendall()은 TCP 패킷이 완전히 전송될 때까지 블로킹
        client_socket.sendall(send_msg.encode('utf-8'))  # 메시지 전송
        
# 데이터 수신 스레드
def handler_rx():
    while is_active[0]:
        # 서버가 데이터를 보낼 때까지 블로킹
        rcvd_msg = client_socket.recv(1024).decode('utf-8')  # 메시지 수신 (blocking)
        
        # 서버에서 null 값이 오면 종료
        if not rcvd_msg:
            break

        print(f"Received msg: {rcvd_msg}")

    is_active[0] = False  # 수신이 중단되면 프로그램 종료
    
# 스레드 생성 및 실행
thread_tx = threading.Thread(target=handler_tx)
thread_rx = threading.Thread(target=handler_rx)

thread_tx.start()
thread_rx.start()

# 스레드 동기화
thread_tx.join()
thread_rx.join()
