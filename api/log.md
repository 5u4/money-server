# Log API Request/Response

## Index

Required: `LOGIN`

GET /api/v1/logs

### Response

```json
{
    "data": {
        "logs": [
            {
                "action": "SOME_ACTION",
                "timestamp": 1524366369,
                "data": {}
            }
        ]
    }
}
```

## Action Lists

### Auth

 - [LOGIN](#login)
 - [LOGOUT](#logout)

### User

 - [CREATE_USER](#create_user)
 - [DELETE_USER](#delete_user)

### Wallet

 - [CREATE_WALLET](#create_wallet)

### Store

 - [CREATE_STORE](#create_store)
 
## Auth

### LOGIN

```json
{
    "action": "LOGIN",
    "timestamp": 1524371975,
    "data": {
        "success": true,
        "ip": "127.0.0.1"
    }
}
```

### LOGOUT

```json
{
    "action": "LOGOUT",
    "timestamp": 1524371752,
    "data": {
        "ip": "127.0.0.1"
    }
}
```

## User

### CREATE_USER

```json
{
    "action": "CREATE_USER",
    "timestamp": 1524371345,
    "data": {
        "name": "alex",
        "email": "alex@gmail.com",
        "ip": "127.0.0.1"
    }
}
```

### DELETE_USER

```json
{
    "action": "DELETE_USER",
    "timestamp": 1524372628,
    "data": {
        "ip": "127.0.0.1"
    }
}
```

## Wallet

### CREATE_WALLET

```json
{
    "action": "CREATE_WALLET",
    "timestamp": 1524371796,
    "data": {
        "wallet_id": 242
    }
}
```

## Store

### CREATE_STORE

```json
{
    "action": "CREATE_STORE",
    "timestamp": 1524413142,
    "data": {
        "store_id": 106,
        "ip": "127.0.0.1"
    }
}
```
