# Auth API Request/Response

 - [Login](#login)
 - [Logout](#logout)

## Login

POST /api/v1/auth/login

### Request

```json
{
    "email": "email@example.com",
    "password": "password"
}
```

### Response

```json
{
    "data": {
        "access_token": "SomeRandomAccessToken"
    },
    "success": true
}
```

## Logout

Required: `LOGIN`

POST /api/v1/auth/logout

### Response

```json
{
    "success": true
}
```
