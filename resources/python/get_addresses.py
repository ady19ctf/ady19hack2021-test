import mcrpc
import sys

if __name__ == "__main__":
    args=sys.argv
    # args[1]:IP address
    # args[2]:Port
    # args[3]:BC JSON-RPC Client user
    # args[4]:BC JSON-RPC Client password

    client = mcrpc.RpcClient(args[1] ,args[2] ,args[3] ,args[4])
    try: 
        addresses=client.getaddresses()
        print(addresses)
    except IndexError as e:
        print(0)