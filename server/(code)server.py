import socket 
import threading

HOST = "127.0.0.1" # 같은 컴퓨터 내에서 통신 가능
PORT = 12345

# 전역변수
# 서버가 활성화 상태인지 유지하는 역할
is_active = [True] 
# 리스트를 사용하는 이유는 멀티스레드 환경에서도 상태공유가 가능
# bool값을 직접 변경하면 각 스레드에서 독립적으로 관리될 수 있지만,
# 리스트는 참조형이라서 공유된다.

# 데이터 전송 함수
def handler_tx(client_socket: socket.socket):
    while is_active[0]:
        send_msg = input("Text : ")
        # blocking 사용자의 입력을 기다린다.
        if send_msg.lower() == "exit":
            client_socket.close()
            is_active[0] = False # 서버가 종료
            break
            
        client_socket.sendall(send_msg.encode('utf-8'))
        # 인코딩을 사용하여 문자열을 바이트 데이터로 변환 후 전송

# 데이터 수신 함수수
def handler_rx(client_socket: socket.socket):
    while is_active[0]:
        rcvd_msg = client_socket.recv(1024).decode('utf-8')
        # 바이트 데이터를 문자열로 변환
        if not rcvd_msg:
            # 클라이언트가 연결을 종료하면 msg가 비어있다. 
            # break로 종료
            break
        
        print(f"Received msg: {rcvd_msg}")
    
    is_active[0] = False 
    # 서버를 종료하기 위해 전역변수를 False로 설정
    
# 서버 소켓 설정
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
# AF_INET : ipv4 주소 체계를 사용
# SOCK_STREAM : TCP (연결형 소켓) 방식 사용

# 바인드
server_socket.bind((HOST,PORT)) # 해당 IP와 포트에서 서버 실행

# 리슨
server_socket.listen(1) # 최대 1개의 클라이언트 연결을 대기
print(f"[Listen] {HOST}, {PORT}")

# 클라이언트 연결 수락
client_socket, client_addr = server_socket.accept()
# 클라이언트가 접속하면 새로운 소켓과 주소를 반환
# client_socket은 클라이언트와 통신을 담당한다.

# 스레드 생성 및 실행
thread_tx = threading.Thread(target=handler_tx, args=(client_socket,))
thread_rx = threading.Thread(target=handler_rx, args=(client_socket,))
# ,을 통해 튜플 형태로 전달
# 스레드는 특정 함수를 실행-> 함수지정(target=), arg= 튜플로 인자전달
# 함수를 그냥 호출하면 스레드가 생성되기도 전에 실행되버림, 그래서 함수 참조와 인자전달을 따로둠


thread_tx.start() # 메세지 전송
thread_rx.start() # 메세지 수신
# 각각 독립적인 스레드에서 실행하여, 동시에 메시지를 주고받음

# 스레드 종료 대기
thread_rx.join()
thread_tx.join()
# 모든 스레드가 종료될 때까지 프로그램이 종료되지 않도록 대기 (=논데몬)
