# 1. 사용자 입력오류
# num = int(input("숫자를 입력하세요: "))

# try:
#     if num == 1:
#         raise ValueError
#     else:
#         raise NameError
# except ValueError:
#     print("ValueError 예외 발생")
# except NameError:
#     print("NameError 예외 발생")

# print(f"결과: 0")


# 이런식으로 예외 

try:
    print("pos")
    # print(1/0)
    print("bar")
    # kin()

    raise IndexError("인덱스 예외 발생")
except ValueError:
    print("ValueError 발생")
except IndexError as e:
    print(f"예외 발생: {e}")
except NameError as e:
    print(f"예외 발생: {e}")
except ZeroDivisionError:
    print("ZeroDivisionError 예외 발생")

print(f"결과: 0" )


num = 4
try:
    print("1")
    
    if num == 1:
        raise KeyboardInterrupt
    
    print("2")
    
except KeyboardInterrupt:
    print("4")
else:
    print("5")
finally:
    print("6")

print("7")

# 2. 파일 오류
# FileNotFoundError 발생 가능
# file = open("non_file.txt", "r")
# content = file.read()
# 예외를 만들 수 있는 사람은 
# 1. 파이썬 인터프리터
# 2. 프로그래머

