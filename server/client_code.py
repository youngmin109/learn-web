import socket

# socket 생성 (IPv4 or IPv6, TCP or UDP)
# server에 따라 TCP or UDP를 결정한다.
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# connect (서버 주소, 서버 포트)
client_socket.connect(("127.0.0.1", 5500))

while True:
    send_msg = input("Input text: ")

    if send_msg.lower() == "exit":
        break
    # 입력된 데이터를 서버로 전송
    client_socket.sendall(send_msg.encode("utf-8"))
    # 보낼려는 데이터가 다 갔을 때, 다음으로 넘어간다(sendall == blocking함수)

    # 서버로부터 수신한 데이터를 출력
    rcvd_msg = client_socket.recv(1024).decode('utf-8')

    print(f"[Client rcvd data]: {rcvd_msg}")

client_socket.close()
print("클라이언트 종료")

