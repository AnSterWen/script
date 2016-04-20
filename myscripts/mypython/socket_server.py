import socket,sys
sock = socket.socket()
server_address  = ('localhost',10000)
sock.bind(server_address)
sock.listen(5)
while True:
    connection,client_address = sock.accept()
    try:
        while True:
            data = connection.recv(1024)
            if data:
                connection.sendall(data)
            else:
                break
    finally:
        connection.close()
