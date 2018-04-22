# Wallet API Request/Response

 - [Index](#index)
 - [Create](#create)

## Index

Required: `LOGIN`

GET /api/v1/wallets

### Response

```json
{
    "data": {
        "wallets": [
            {
                "id": 3,
                "name": "Cash",
                "owner": "alex",
                "balance": 0
            },
            {
                "id": 41,
                "name": "Cash",
                "owner": "alex",
                "balance": 20
            }
        ]
    }
}
```


## Create

Required: `LOGIN`

Optional: `balance`

POST /api/v1/wallets

### Request

```json
{
	"name": "Cash",
	"balance": 0
}
```

### Response

```json
{
    "success": true
}
```
