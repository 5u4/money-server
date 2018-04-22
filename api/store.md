# Store API Request/Response

 - [Index](#index)
 - [Create](#create)

## Index

Required: `LOGIN`

GET /api/v1/stores

### Response

```json
{
    "data": {
        "stores": [
            {
                "id": 89,
                "name": "McDonald's"
            },
            {
                "id": 106,
                "name": "KFC"
            }
        ]
    }
}
```

## Create

Required: `LOGIN`

POST /api/v1/stores

### Request

```json
{
	"name": "McDonald's"
}
```

### Response

```json
{
    "success": true
}
```
