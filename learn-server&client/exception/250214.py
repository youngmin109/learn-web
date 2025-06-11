# 1
num = 2

try: # 해피시나리오
    print("10")
    
    if num == 1:
        raise ValueError
    else: 
        raise ZeroDivisionError    
    print("20")
    
except ValueError: 
    print("30")

print("40")

# 위 코드는 오류가 나온다. 
# why ? 임의로 오류를 발생시켰을 때, 예외처리를 할 수 있는 코드가 없다.

# 2
num = 2

try: # 해피시나리오
    print("10")
    
    if num == 1:
        raise ValueError
    else: 
        raise ZeroDivisionError    
    print("20")
    
except Exception:
    print("21")
except ValueError: 
    print("30")

print("40")

# 10, 21, 40 
# why 상위 클래스인 exception이 상위 클래스

# 3
num = 2

try: # 해피시나리오
    print("10")
    
    if num == 1:
        raise ValueError
    else: 
        raise KeyboardInterrupt   
    print("20")
    
except Exception:
    print("21")
except ValueError: 
    print("30")
except: # 모든 예외를 의미
    print("32")

print("40")

