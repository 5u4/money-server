# Transaction API Request/Response

 - [Index](#index)
 - [Create](#create)

## Index

Required: `LOGIN`

GET /api/v1/transactions

### Response

```json
{
    "data": {
        "transactions": [
            {
                "id": 108,
                "timestamp": 1524423012,
                "amount": -50,
                "wallet_id": 107,
                "store_id": null,
                "service_id": null
            },
            {
                "id": 147,
                "timestamp": 1524423005,
                "amount": 50,
                "wallet_id": 107,
                "store_id": 3,
                "service_id": 195
            }
        ]
    }
}
```

## Create

Required: `LOGIN`

Optional: `store_id`, `service_id`

POST /api/v1/stores

### Request

```json
{
	"amount": 50,
	"wallet_id": 107,
	"store_id": 3,
	"service_id": 195
}
```

### Response

```json
{
    "success": true
}
```
