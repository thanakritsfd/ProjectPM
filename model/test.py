import sys
from datetime import datetime, timedelta

# ข้อสมมุติ: datetime object จาก string
date_string = "23/11/2023 00:00"
date_object = datetime.strptime(date_string, "%d/%m/%Y %H:%M")

# วันที่และเวลาปัจจุบัน
current_datetime = datetime.now()

# คำนวณ timedelta
time_difference = current_datetime - date_object

# กำหนด encoding ใน sys.stdout
sys.stdout.reconfigure(encoding='utf-8')

# พิมพ์ผลลัพธ์
print("ระยะเวลาทั้งหมด:", time_difference)
print("จำนวนวัน:", time_difference.days, "วัน")
print("จำนวนวัน (เป็นทศนิยม):", time_difference.total_seconds() / (60 * 60 * 24), "วัน")
