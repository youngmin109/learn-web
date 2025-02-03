import socket

# 소켓 생성 (TCP or UDP, IP 주소 버전: v4 or v6)
# TCP : socket.SOCK_STREAM
# UDP : socket.SOCK_DGRAM
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# bind (ip 주소, port 주소)
server_socket.bind(("127.0.0.1",5500))

# listen(큐의 개수)
server_socket.listen(5)
print(f"listen on 127.0.0.1:5500")

## ----- 여기까지 적으면 종료해버린다. 다음절차가 필요
# accept(), -> 사용자로부터 연결 요청을 받았을 때 -> 새로운 소켓 생성
# 클라이언트 -> connect()
server_socket.accept() # 1. (사용자의 연결요청이 올때까지) Block 2. 새로운 소켓 생성

# 왜 새로운 소켓을 만들어야 할까? 
# 처음 만들어진 소켓은은 연결 요청/수락용으로만 만들어졌고, 사용자 수 만큼 소켓이 필요하다.

print("hello")
