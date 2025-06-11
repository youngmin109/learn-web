import socket
import threading

HOST = "210.101.236.180"
PORT = 5500

client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client_socket.connect((HOST,PORT))

is_active = [True]

# 데이터 전송
def handler_tx():
    while is_active[0]:
        send_msg = input("Text : ")
        
        if send_msg.lower() == "exit":
            client_socket.close()
            is_active[0] = False
            break
        
        client_socket.sendall(send_msg.encode('utf-8'))

# 데이터 수신
def handler_rx():
    while is_active[0]:
        rcvd_msg = client_socket.recv(1024).decode('utf-8')
        # 여기서 blocking 되지만 서버로부터 'null'값이 올 때 종료
        if not rcvd_msg:
            break
        
        print(f"Received msg: {rcvd_msg}")
    
    is_active[0] = False

    
thread_tx = threading.Thread(target=handler_tx)
thread_rx = threading.Thread(target=handler_rx)

thread_tx.start()
thread_rx.start()

thread_tx.join()
thread_rx.join()
# 연결은 클라이언트만 가능하지만,         
# 연결종료는 둘다 할 수 있다.
# rcv에 'null' 값이 온다. 
