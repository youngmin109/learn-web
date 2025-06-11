import socket

try:
    print("시작")
    
    my_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    my_socket.connect(("127.0.0.1", 12345)) # 1. 예외 발생
    # 서버가 동작하지 않을 때, 나의 네트워크에 문제
        
    print(my_socket.recv(1024).decode('utf-8')) # 2. 예외 발생
    # 연결이 비정상적으로 종료 되었을 때
    
    # my_socket.close() # with가 있으면면, 자원을 반납할 필요가 없다.
except:
    print("소켓 예외 발생 ^^;;")
    
else:
    my_socket.sendall("OK".encode('utf-8'))
    
finally:
    my_socket.close() # except에 두면 사용자의 수만큼 예외처리 필요..
    
print("종료")