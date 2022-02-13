import mcrpc
import sys

if __name__ == "__main__":
    args=sys.argv
    # args[1]:IP address
    # args[2]:Port
    # args[3]:BC JSON-RPC Client user
    # args[4]:BC JSON-RPC Client password
    # args[5]:voter address


    client = mcrpc.RpcClient(args[1] ,args[2] ,args[3] ,args[4])
    try: 
        asset=client.getaddressbalances(args[5])[0]['qty']
        print(asset)
    except IndexError as e:
        print(0)