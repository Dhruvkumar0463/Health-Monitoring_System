import smtplib, ssl

port = 587  # For starttls
smtp_server = "smtp.stackmail.com"
sender_email = "noreply@healthmonitoring.tech"
receiver_email = "parthparikh03@gmail.com"
password = "health@123"
message = """\
Subject: Hi there

This message is sent from Python.By parth"""

message+=str("hello shyam")

context = ssl.create_default_context()
with smtplib.SMTP(smtp_server, port) as server:
    server.ehlo()  # Can be omitted
    server.starttls(context=context)
    server.ehlo()  # Can be omitted
    server.login(sender_email, password)
    server.sendmail(sender_email, receiver_email, message)


# import library
import math, random


# function to generate OTP
# def generateOTP():
#     # Declare a string variable
#     # which stores all string
#     string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
#     OTP = ""
#     length = len(string)
#     for i in range(6):
#         OTP += string[math.floor(random.random() * length)]
#
#     return OTP
#
#
# # Driver code
# if __name__ == "__main__":
#     print("OTP of length 6:", generateOTP())



