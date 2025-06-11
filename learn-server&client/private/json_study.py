# 파이썬에서 JSON에 대한 Serializer, Parser가 있는가? OK
# Data format -JSON
import json


bar = {"name" : "ycjung", "age" : 20, "roomnum" : [404, 511]}

# 네트워크로 전송 -> 문자열(Text) -> JSON
# bar는 메모리에 존재하는 데이터 -> JSON Serializer -> JSON 기반의 Text

# with open("text.txt", "w") as file_handler:
    # json.dump(bar, file_handler) # dump -> serializ
    
# 코드에서 가져온 포맷팅을 그대로 가져온다.
# 시리얼라이징
json_str = json.dumps(bar) # s란 문자열로 만들어준다. 없으면 파일

print(type(json_str), json_str)

# parsing -> 예외가 있다. 23,24라인
rcvd_data = json.loads(json_str) # 문자열 -> 딕셔너리

print(rcvd_data.get('phone')) # get을 이용해서 
print(rcvd_data.get('name')) 
# 값이 없을 경우 파싱을 할 때 어떻게 처리되는지 봐야한다. key error or none
# 파이썬에서 dic의 값을 찾을 때, 파이썬에서는 직접접근[]과, get()을 이용해서 찾는다.

print(type(rcvd_data))
print(type(rcvd_data['age']), type(rcvd_data['roomnum']), \
    type(rcvd_data['name']))

# int list str
# 문자열로 포맷팅을 했지만, 각각 다른 자료형을 가졌다.
# 매개체가 문자열이지만, 
