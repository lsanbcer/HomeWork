# API Docs

| User API                                                   | Ubike api                                                             |
|:---------------------------------------------------------- |:--------------------------------------------------------------------- |
| [Login](https://github.com/lsanbcer/HomeWork#login)        | [Search Sna](https://github.com/lsanbcer/HomeWork#search-sna)         |
| [Register](https://github.com/lsanbcer/HomeWork#register)  | [Search All Sna](https://github.com/lsanbcer/HomeWork#search-all-sna) |
| [Userinfo](https://github.com/lsanbcer/HomeWork#userinfo)  |                                                                       |
| [Logout](https://github.com/lsanbcer/HomeWork#logout)      |                                                                       |

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

***

# Ubike api

**主要欄位說明** : 

| Key     | 說明             |
|:------- |:--------------- |
| sno     | 站點代號         |
| sna     | 中文場站名稱     |
| tot     | 場站總停車格     |
| sbi     | 可借車位數       |
| sarea   | 中文場站區域     |
| mday    | 資料更新時間     |
| lat     | 緯度            |
| lng     | 經度            |
| ar      | 中文地址         |
| sareaen | 英文場站區域     |
| snaen   | 英文場站名稱     |
| aren    | 英文地址         |
| bemp    | 可還空位數       |
| act     | 場站是否暫停營運 |

# Search Sna

搜尋場站。
網址後方加上參數`?sna=場站名稱`來搜尋場站。

**URL** : `/api/UbikeSearch?sna=parameters`

**URL Parameters** : 字串，場站名稱。例: `西本願寺廣場`。

**Method** : `GET`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": {
        "sno": "0275",
        "sna": "西本願寺廣場",
        "tot": "58",
        "sbi": "12",
        "sarea": "萬華區",
        "mday": "20210508220221",
        "lat": "25.040988",
        "lng": "121.507688",
        "ar": "中華路一段/長沙街二段路口西南側人行道(西本願寺)(鄰近國軍歷史文物館/中山堂/西門紅樓)",
        "sareaen": "Wanhua Dist.",
        "snaen": "Nishi Honganji Square",
        "aren": "Sec. 1, Zhonghua Rd./Sec. 2, Changsha St. intersection(Southwest)",
        "bemp": "46",
        "act": "1"
    }
}
```

# Search All Sna

查詢全部場站資訊。
網址後方沒有帶參數時，顯示出全部場站資訊。

**URL** : `/api/UbikeSearch/`

**Method** : `GET`

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
    "data": {
        "0001": {
            "sno": "0001",
            "sna": "捷運市政府站(3號出口)",
            "tot": "180",
            "sbi": "41",
            "sarea": "信義區",
            "mday": "20210509191919",
            "lat": "25.0408578889",
            "lng": "121.567904444",
            "ar": "忠孝東路/松仁路(東南側)",
            "sareaen": "Xinyi Dist.",
            "snaen": "MRT Taipei City Hall Stataion(Exit 3)-2",
            "aren": "The S.W. side of Road Zhongxiao East Road & Road Chung Yan.",
            "bemp": "138",
            "act": "1"
        },
        "0002": {
            "sno": "0002",
            "sna": "捷運國父紀念館站(2號出口)",
            "tot": "48",
            "sbi": "10",
            "sarea": "大安區",
            "mday": "20210509191921",
            "lat": "25.041254",
            "lng": "121.55742",
            "ar": "忠孝東路四段/光復南路口(西南側)",
            "sareaen": "Daan Dist.",
            "snaen": "MRT S.Y.S Memorial Hall Stataion(Exit 2.)",
            "aren": "Sec,4. Zhongxiao E.Rd/GuangFu S. Rd",
            "bemp": "38",
            "act": "1"
        },
        
        ...
        
        "0405": {
            "sno": "0405",
            "sna": "捷運科技大樓站(台北教育大學)",
            "tot": "66",
            "sbi": "4",
            "sarea": "大安區",
            "mday": "20210509191930",
            "lat": "25.024685",
            "lng": "121.544156",
            "ar": "和平東路二段134號(前方)",
            "sareaen": "Daan Dist.",
            "snaen": "MRT Technology Building Station",
            "aren": "No. 134, Heping E. Rd. (front)",
            "bemp": "60",
            "act": "1"
        }
    }
}
```
