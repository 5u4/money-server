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
                "owner": "alex"
            },
            {
                "id": 41,
                "name": "Cash",
                "owner": "alex"
            }
        ]
    }
}
```


## Create

Required: `LOGIN`

POST /api/v1/wallets

### Request

```json
{
	"name": "Cash"
}
```

### Response

```json
{
    "success": true
}
```
