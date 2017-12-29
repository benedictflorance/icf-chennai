# ICF Chennai

## Route Documentation
- Adjust the base URL of the API requests to the URL where the website is hosted.
- Every response is a JSON object with either of the two keys `data` and `errors` and a `status` key.
- Every `errors` key is an object consisting of multiple errors with each error having a `title` key.
- `status` key has `200` for a successful request, `400` for a bad request, `401` for an unauthorized request and `500` for an internal server error.
- All API requests except the login route must be made with the token.

### POST Routes

Path                               |  Description
-----------------------------------|---------------
`/api/login`                       | User Login
`/api/logout`                      | User Logout
`/api/admin/newuser`               | Admin Route for adding new users
`/api/admin/edituser`              | Admin Route for editing an user's profile
`/api/admin/getall`                | Admin Route for getting all the users' profile
`/api/admin/getuser`               | Admin Route for getting an user's profile
`/api/user/profile`                | User Route for getting his/her profile
`/api/user/editprofile`            | User Route for editing his/her profile
`/api/rakes/new`                   | Route for adding a new rake
`/api/rakes/getall`                | Route for getting all the rakes
`/api/rakes/{rake_num}`            | Route for getting a rake by it's number
`/api/rakes/{rake_num}/coaches`    | Route for getting all the coaches of a rake number
`/api/rakes/{rake_num}/statuses`   | Route for getting the statuses of all the coaches of a rake
`/api/rakes/{rake_num}/positions`  | Route for getting the positions of all the coaches of a rake
`/api/coaches/new`                 | Route for addin a new coach
`/api/coaches/getall`              | Route for getting all the coaches
`/api/coaches/{coach_num}`         | Route for getting a coach by its number
`/api/coaches/{coach_num}/status`  | Route for getting the status of a coach
`/api/coaches/{coach_num}/position`| Route for getting the position of a coach
`/api/status/new`                  | Route for adding a new status/editing an existing status of a coach
`/api/status/getall`               | Route for getting all the statuses
`/api/position/new`                | Route for adding a new position/editing an existing position of a coach
`/api/position/getall`             | Route for getting all the positions

### POST /api/login

#### Parameters
    {
    "username": string,
    "password": string
    }
    
#### Response
    {
    "data": {
        "token": string,
        "message": string
    },
    "status": 200
    }
### POST /api/logout

#### Parameters
     {
     "token": string
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/admin/newuser
> Admin can add new users

> Role should be "read"/"write"/"admin". "read" role allows only read access. "write" role allows adding new rakes, coaches, positions and statuses. "admin" role allows write access and access for adding new users, editing a user's profile and credentials.

> Position means the rank of job eg. SSE or AWM

> Position, E-Mail and Mobile are optional

#### Parameters

     {
     "token": string,
     "name": string,
     "password": string,
     "role": string,
     "position": string,
     "email": email,
     "mobile" numeric,
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
    
### POST /api/admin/edituser

> Admin can edit user profile including credentials

#### Parameters
    {
     "token": string,
     "name": string,
     "password": string,
     "role": string,
     "position": string,
     "email": email,
     "mobile" numeric,
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/admin/getall

> Admin can get all the users' profile
#### Parameters
     {
     "token": string
     }
#### Response 
> Considering only 2 users

    {
    "data": [
        {
            "name": string,
            "username": string,
            "role": string,
            "position": string,
            "email": email,
            "mobile": numeric
        },
        {
            "name": string,
            "username": string,
            "role": string,
            "position": string,
            "email": email,
            "mobile": numeric
        },
    ],
    "status": 200
    }
 ### POST /api/admin/getuser
 #### Parameters
     {
     "token": string,
     "username": string
     }
#### Response 
    {
    "data": 
        {
            "name": string,
            "username": string,
            "role": string,
            "position": string,
            "email": email,
            "mobile": numeric
        },
    "status": 200
    }
### POST /api/user/profile
#### Parameters
     {
     "token": string,
     }
#### Response 
    {
    "data": 
        {
            "name": string,
            "username": string,
            "role": string,
            "position": string,
            "email": email,
            "mobile": numeric
        },
    "status": 200
    }
### POST /api/user/editprofile
#### Parameters
> User cannot change his password. He/She needs to request the admin.

> Position, E-mail and Mobile are optional.

    {
     "token": string,
     "name": string,
     "role": string,
     "position": string,
     "email": email,
     "mobile" numeric,
     }
 #### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
