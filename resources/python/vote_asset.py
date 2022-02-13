import mcrpc
import sys


if __name__ == "__main__":
    args=sys.argv
    # args[1]:IP address
    # args[2]:Port
    # args[3]:BC JSON-RPC Client user
    # args[4]:BC JSON-RPC Client password
    # args[5]:voter address
    # args[6]:cantidate address
    # args[7]:asset name

    client = mcrpc.RpcClient(args[1] ,args[2] ,args[3] ,args[4])
    print(client.sendassetfrom(args[5], args[6], args[7], 1))