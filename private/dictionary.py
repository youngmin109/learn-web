bar = {"배영민" : 12345, "윤성빈" : 67890, "김효찬" : 12345, "배영민" :3333}

print(bar["배영민"])

print(bar.items())
print(type(bar["김효찬"]))

for key, value in bar.items():
    print(f"key: {key} value: {value}")
    