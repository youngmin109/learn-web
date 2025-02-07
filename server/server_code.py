import socket
import threading

def handler_client(client_socket, client_addr):
    while True: 
            # 클라이언트로부터 메세지를 수신신
        rcvd_data = client_socket.recv(1024).decode('utf-8') # 1024 숫자는 삽, 한번에 몇 byte씩 받아올까
        # 여기서!recv함수는 비동기화, 동기화 일까? 또, 값의 자료형은 무엇인가?
        # Blocking 함수이다. 메세지를 수신하기전까지 밑으로 내려가지 않는다.
        
        if not rcvd_data:
            print("[Closed from client]")
            break
        
        print(f"[Rcvd data ({client_addr})]: {rcvd_data}") 
        # 자료형은 byte이다. 

        # 수신한 메세지를 클라이언트로 전송
        client_socket.sendall(rcvd_data.encode('utf-8'))

    client_socket.close()
        
# 소켓 생성 (TCP or UDP, IP 주소 버전: v4 or v6)
# TCP : socket.SOCK_STREAM
# UDP : socket.SOCK_DGRAM
HOST = "127.0.0.1" # 서버의 IP주소 -> 문자형
PORT = 5500 # 포트 주소 -> 정수형
num_of_threads = 0

# socket 생성
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# bind (ip 주소, port 주소)
server_socket.bind((HOST,PORT)) # src IP, src Port

# listen(큐의 개수)
server_socket.listen(1)
print(f"listen on {HOST}, {PORT}")
# 또 다른 클라이언트가 연결요청했을 떄, accept 되는 이유는 
# 내부적으로 listen에서 또다른 스레드가 돌기 때문이다.

while True: 
    # accept(),  1. (사용자의 연결요청이 올때까지) Block 
    # 2. 사용자로부터 연결 요청을 받았을 때 -> 새로운 소켓 생성
    # 클라이언트 -> connect()
    client_socket, client_addr = server_socket.accept() 

    # 왜 새로운 소켓을 만들어야 할까? 
    # 처음 만들어진 소켓은 연결 요청/수락용으로만 만들어졌고, 사용자 수 만큼 소켓이 필요하다.
    print(f"[Accept]] : {client_addr}")
    
    # 새로운 쓰레드 생성
    client_thread = threading.Thread(target=handler_client,
                    arg=(client_socket,client_addr))
    
    num_of_threads += 1
    print(f"쓰레드 생성 : {num_of_threads}")
    
    # 생성된 쓰레드 실행
    client_thread.start()
    
server_socket.close()