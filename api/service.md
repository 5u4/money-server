# Service API Request/Response

 - [Index](#index)
 - [Create](#create)

## Index

Required: `LOGIN`

GET /api/v1/services

### Response

```json
{
    "data": {
        "services": [
            {
                "id": 195,
                "name": "Meal"
            }
        ]
    }
}
```

## Create

Required: `LOGIN`

POST /api/v1/services

### Request

```json
{
	"name": "Meal"
}
```

### Response

```json
{
    "success": true
}
```
