# Log API Request/Response

 - [Index](#index)

## Index

Required: `LOGIN`

GET /api/v1/logs

### Response

```json
{
    "data": {
        "logs": [
            {
                "action": "CREATE_WALLET",
                "timestamp": 1524366369,
                "data": {
                    "wallet_id": 104
                }
            }
        ]
    }
}
```
