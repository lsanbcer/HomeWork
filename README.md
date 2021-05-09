# API Docs

| User API                                                |
| ------------------------------------------------------- |
| [Login](https://github.com/lsanbcer/Elder#login)        |
| [Register](https://github.com/lsanbcer/Elder#register)  |
| [Userinfo](https://github.com/lsanbcer/Elder#userinfo)  |
| [Logout](https://github.com/lsanbcer/Elder#logout)      |

***

# User API

# Login

每次登入成功後產生一組新的token存進資料表，之後在做查看、登出等動作都會驗證這組token來判斷使用者身分。

**URL** : `/api/login/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "email",
    "password": "password"
}
```

**Data example**

```json
{
    "email": "abc@gmail.com",
    "password": "abcd1234"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "message": "Login successfully!",
    "api_token": "hRqb7XJKcz"
}
```

## Error Response

**Condition** : 如果信箱輸入錯誤。

**Code** : `400 BAD REQUEST`

**Content example** :

```json
{
    "message": "Login failed! Please check email."
}
```

# Register

註冊並驗證註冊的資料是否符合，以isAdmin判斷註冊的使用者權限(`1：表示管理者，0：表示一般使用者`)。
成功註冊後會得到token並存到資料表(以便之後需要驗證)。

**URL** : `/api/register/`

**Method** : `POST`

**Auth required** : NO

**Data constraints**

```json
{
    "email": "符合格式的email，唯一性",
    "password": "長度為6~12之間",
    "isAdmin": "預設為0",
    "api_token": "由系統亂數產生，長度為10的字串"
}
```

**Data example**

```json
{
    "email": "abcde@gmail.com",
    "password": "abcd1234",
    "isAdmin": "0",
    "api_token": "BSoFh97Uc7"
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "message": "Register as a user.",
    "data": {
        "id": 3,
        "email": "abcde@gmail.com",
        "password": "abcd1234",
        "isAdmin": "0",
        "api_token": "BSoFh97Uc7",
        "updated_at": "2021-05-09 04:12:35",
        "created_at": "2021-05-09 04:12:35",
    }
}
```

## Error Response

**Condition** : 如果email已經被註冊過。

**Code** : `400 BAD REQUEST`

**Content example** :

```json
{
    "message": {
        "email": [
            "The email has already been taken."
        ]
    }
}
```

# Userinfo

查看會員資料。
如果是管理者，回傳所有會員資料；一般使用者則回傳自己的資料。

**URL** : `/api/user/`

**Method** : `GET`

**Auth required** : YES

**Authorization** : Bearer Token

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": {
        "mail": "abcde@gmail.com",
        "password": "abcd1234"
    }
}
```

# Logout

使用者登出，登出後將登入時產生的token從資料表中清除，該欄位的值會填入`logged out`字串代表使用者已登出。

**URL** : `/api/logout/`

**Method** : `GET`

**Auth required** : YES

**Authorization** : Bearer Token

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "message": "You are logged out!"
}
```
