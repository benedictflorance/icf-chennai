# ICF Chennai

## Route Documentation
- Adjust the base URL of the API requests to the URL where the website is hosted.
- Every response is a JSON object with either of the two keys `data` and `errors` and a `status` key.
- Every `errors` key is an object consisting of multiple errors with each error having a `title` key.
- `status` key has `200` for a successful request, `400` for a bad request, `401` for an unauthorized request and `500` for an internal server error.
- All API requests except the login route must be made with the token.

### Notes for the App
- [ ] All dates parameter in the request must be of the format yyyy-mm-dd
- [ ] In the new user registration page, make dropdowns for the role key with the values "admin", "write", "read".
- [ ] Send the token key for all the API requests except the login route.
- [ ] In the new rake registration page, make dropdowns for railway key with the railway zone code values
- [ ] In the new coach registration page, make dropdown for the rake number key (get the list of rake numbers for the current rakes)
- [ ] In the coach registration page, make dropdown for the type key with the values "trailer", "driving", "motor" and "handicapped"
- [ ] In the new coach status and position page, make dropdown for the coach number key (get the list of coach numbers for the current coaches)
- [ ] In the shell received page display the list of coaches present in the shell received line plus the paint shop and the total quantity.
- [ ] Convert / to _ if {rake_num} or {coach_num} is present in the URL

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
`api/rakes/edit`                   | Route for editing a particular rake
`api/rakes/delete`                 | Route for deleting a particular rake
`/api/rakes/{rake_num}`            | Route for getting a rake by it's number
`/api/rakes/{rake_num}/coaches`    | Route for getting all the coaches of a rake number
`/api/rakes/{rake_num}/statuses`   | Route for getting the statuses of all the coaches of a rake
`/api/rakes/{rake_num}/positions`  | Route for getting the positions of all the coaches of a rake
`/api/coaches/new`                 | Route for adding a new coach
`api/coaches/edit`                 | Route for editing a particular coach
`api/coaches/delete`               | Route for deleting a particular coach
`/api/coaches/getall`              | Route for getting all the coaches
`/api/coaches/{coach_num}`         | Route for getting a coach by its number
`/api/coaches/{coach_num}/status`  | Route for getting the status of a coach
`/api/coaches/{coach_num}/position`| Route for getting the position of a coach
`/api/status/new/{field_name}`                  | Route for adding a new status/editing an existing status of a coach
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
> User cannot change his password. He/She needs to request the admin.

> Position, E-mail and Mobile are optional.

#### Parameters
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
### POST /api/rakes/new
> Only "write" and "admin" role users can add new rakes
#### Parameters
    {
     "token": string,
     "railway": string,
     "rake_num": string,
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/rakes/edit
> Only "write" and "admin" role users can edit rakes

> `old_rakenum` stands for the rake to be edited and it is required.

> Out of `railway` and `rake_num`, atleast one paramater is required for editing.
#### Parameters
    {
     "token": string,
     "old_rakenum": string,
     "railway": string,
     "rake_num": string,
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/rakes/{rake_num}/delete
> Replace {rake_num} with the rake number
#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/rakes/getall
#### Parameters
     {
     "token": string,
     }
#### Response 
> Considering only 2 rakes

    {
    "data": [
        {
            "railway": string,
            "rake_num": string
        },
        {
            "railway": string,
            "rake_num": string
        },        
    ],
    "status": 200
}
### POST /api/rakes/{rake_num}
> Replace {rake_num} with the rake number
#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": {
        "railway": string,
        "rake_num": string
    },
    "status": 200
    }
### POST /api/rakes/{rake_num}/coaches
> Replace {rake_num} with the rake number
#### Parameters
     {
     "token": string,
     }
#### Response
> Considering only 2 coaches are present in the rake
    
    {
    "data": [
        {
            "coach_num": string,
            "type": string
        },
        {
            "coach_num": string,
            "type": string
        },
    ],
    "status": 200
    }
### POST /api/rakes/{rake_num}/statuses
> Replace {rake_num} with the rake number
#### Parameters
     {
     "token": string,
     }
#### Response
> Considering only 2 statuses

> All date formats must be yyyy-mm-dd

    {
    "data": [
        {
            "shell_rec": date/null,
            "intake": date/null,
            "agency": string/null,
            "conduit": date/null,
            "coupler": date/null,
            "ew_panel": date/null,
            "roof_tray": date/null,
            "ht_tray": date/null,
            "ht_equip": date/null,
            "high_dip": date/null,
            "uf_tray": date/null,
            "uf_trans": date/null,
            "uf_wire": string/null,
            "off_roof": date/null,
            "roof_clear": date/null,
            "off_ew": date/null,
            "ew_clear": date/null,
            "mech_pan": string/null,
            "off_tf": date/null,
            "tf_clear": date/null,
            "tf_prov": date/null,
            "lf_load": date/null,
            "off_pow": date/null,
            "power_hv": date/null,
            "off_dip": date/null,
            "dip_clear": date/null,
            "lower": date/null,
            "off_cont": date/null,
            "cont_hv": date/null,
            "load_test": date/null,
            "rmvu": date/null,
            "panto": date/null,
            "pcp_clear": date/null,
            "bu_form": date/null,
            "rake_form": date/null,
            "remarks": string/null,
            "coach_num": string
        },
        {
            "shell_rec": date/null,
            "intake": date/null,
            "agency": string/null,
            "conduit": date/null,
            "coupler": date/null,
            "ew_panel": date/null,
            "roof_tray": date/null,
            "ht_tray": date/null,
            "ht_equip": date/null,
            "high_dip": date/null,
            "uf_tray": date/null,
            "uf_trans": date/null,
            "uf_wire": string/null,
            "off_roof": date/null,
            "roof_clear": date/null,
            "off_ew": date/null,
            "ew_clear": date/null,
            "mech_pan": string/null,
            "off_tf": date/null,
            "tf_clear": date/null,
            "tf_prov": date/null,
            "lf_load": date/null,
            "off_pow": date/null,
            "power_hv": date/null,
            "off_dip": date/null,
            "dip_clear": date/null,
            "lower": date/null,
            "off_cont": date/null,
            "cont_hv": date/null,
            "load_test": date/null,
            "rmvu": date/null,
            "panto": date/null,
            "pcp_clear": date/null,
            "bu_form": date/null,
            "rake_form": date/null,
            "remarks": string/null,
            "coach_num": string
        },
    ],
    "status": 200
    }
### POST /api/rakes/{rake_num}/positions
> Replace {rake_num} with the rake number
#### Parameters
     {
     "token": string,
     }
#### Response
> Considering only 2 positions

    {
    "data": [
        {
            "linename": string,
            "stage": integer/null,
            "lineno":integer/null,
            "coach_num": string
        },
        {
            "linename": string,
            "stage": integer/null,
            "lineno":integer/null,
            "coach_num": string
        },
    ],
    "status": 200
    }
### POST /api/coaches/new
> Type is trailer, driving, motor or handicapped.

> Only "write" and "admin" role users can add new coaches
#### Parameters
    {
    "token": string
    "coach_num": string,
    "rake_num": string,
    "type": string
    }
    
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/coaches/edit
> Only "write" and "admin" role users can edit coaches

> `old_coachnum` stands for the coach to be edited and is required.

> Out of the other three parameters, atleast one paramater is required for editing.
#### Parameters
    {
     "token": string,
     "old_coachnum": string,
     "coach_num": string,
     "rake_num": string,
     "type": string
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/coaches/{coach_num}/delete
> Replace {coach_num} with the coach number
#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/coaches/getall
> Considering only 2 coaches

#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": [
        {
            "coach_num": string,
            "type": string,
            "rake_num": string
        },
        {
            "coach_num": string,
            "type": string,
            "rake_num": string
        },
    ],
    "status": 200
    }
 ### POST /api/coaches/{coach_num}
 > Replace {coach_num} with the coach number
#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": {
        "coach_num": string,
        "type": string,
        "rake_num": string
    },
    "status": 200
    }
### POST /api/coaches/{coach_num}/status
 > Replace {coach_num} with the coach number
#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": {
            "shell_rec": date/null,
            "intake": date/null,
            "agency": string/null,
            "conduit": date/null,
            "coupler": date/null,
            "ew_panel": date/null,
            "roof_tray": date/null,
            "ht_tray": date/null,
            "ht_equip": date/null,
            "high_dip": date/null,
            "uf_tray": date/null,
            "uf_trans": date/null,
            "uf_wire": string/null,
            "off_roof": date/null,
            "roof_clear": date/null,
            "off_ew": date/null,
            "ew_clear": date/null,
            "mech_pan": string/null,
            "off_tf": date/null,
            "tf_clear": date/null,
            "tf_prov": date/null,
            "lf_load": date/null,
            "off_pow": date/null,
            "power_hv": date/null,
            "off_dip": date/null,
            "dip_clear": date/null,
            "lower": date/null,
            "off_cont": date/null,
            "cont_hv": date/null,
            "load_test": date/null,
            "rmvu": date/null,
            "panto": date/null,
            "pcp_clear": date/null,
            "bu_form": date/null,
            "rake_form": date/null,
            "remarks": string/null,
            "coach_num": string,
            "rake_num": string
    },
    "status": 200
    }
### POST /api/coaches/{coach_num}/position
 > Replace {coach_num} with the coach number
#### Parameters
     {
     "token": string,
     }
#### Response
    {
    "data": {
        "linename": string,
        "stage": string/null,
        "lineno": integer/null,
        "coach_num": string,
        "rake_num": string
    },
    "status": 200
    }
### POST /api/status/new/{field_name}
> All date formats must be yyyy-mm-dd

> Replace {field_name} with the field name you want to update. Field name must be in lower case. 

> This route is used for editing an existing status

> `coach_num` is required. Only one parameter can be updated at a time.

#### Parameters
     {
            "token": string,
            "coach_num": string,
            "shell_rec": date/null,
            "intake": date/null,
            "agency": string/null,
            "conduit": date/null,
            "coupler": date/null,
            "ew_panel": date/null,
            "roof_tray": date/null,
            "ht_tray": date/null,
            "ht_equip": date/null,
            "high_dip": date/null,
            "uf_tray": date/null,
            "uf_trans": date/null,
            "uf_wire": string/null,
            "off_roof": date/null,
            "roof_clear": date/null,
            "off_ew": date/null,
            "ew_clear": date/null,
            "mech_pan": string/null,
            "off_tf": date/null,
            "tf_clear": date/null,
            "tf_prov": date/null,
            "lf_load": date/null,
            "off_pow": date/null,
            "power_hv": date/null,
            "off_dip": date/null,
            "dip_clear": date/null,
            "lower": date/null,
            "off_cont": date/null,
            "cont_hv": date/null,
            "load_test": date/null,
            "rmvu": date/null,
            "panto": date/null,
            "pcp_clear": date/null,
            "bu_form": date/null,
            "rake_form": date/null,
            "remarks": string/null,
    }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
  ### POST /api/status/getall
  > Considering only two statuses
  #### Parameters
     {
     "token": string,
     }
  #### Response
    {
    "data": [
        {
            "shell_rec": date/null,
            "intake": date/null,
            "agency": string/null,
            "conduit": date/null,
            "coupler": date/null,
            "ew_panel": date/null,
            "roof_tray": date/null,
            "ht_tray": date/null,
            "ht_equip": date/null,
            "high_dip": date/null,
            "uf_tray": date/null,
            "uf_trans": date/null,
            "uf_wire": string/null,
            "off_roof": date/null,
            "roof_clear": date/null,
            "off_ew": date/null,
            "ew_clear": date/null,
            "mech_pan": string/null,
            "off_tf": date/null,
            "tf_clear": date/null,
            "tf_prov": date/null,
            "lf_load": date/null,
            "off_pow": date/null,
            "power_hv": date/null,
            "off_dip": date/null,
            "dip_clear": date/null,
            "lower": date/null,
            "off_cont": date/null,
            "cont_hv": date/null,
            "load_test": date/null,
            "rmvu": date/null,
            "panto": date/null,
            "pcp_clear": date/null,
            "bu_form": date/null,
            "rake_form": date/null,
            "remarks": string/null,
            "coach_num": string,
            "rake_num": string
        },
        {
            "shell_rec": date/null,
            "intake": date/null,
            "agency": string/null,
            "conduit": date/null,
            "coupler": date/null,
            "ew_panel": date/null,
            "roof_tray": date/null,
            "ht_tray": date/null,
            "ht_equip": date/null,
            "high_dip": date/null,
            "uf_tray": date/null,
            "uf_trans": date/null,
            "uf_wire": string/null,
            "off_roof": date/null,
            "roof_clear": date/null,
            "off_ew": date/null,
            "ew_clear": date/null,
            "mech_pan": string/null,
            "off_tf": date/null,
            "tf_clear": date/null,
            "tf_prov": date/null,
            "lf_load": date/null,
            "off_pow": date/null,
            "power_hv": date/null,
            "off_dip": date/null,
            "dip_clear": date/null,
            "lower": date/null,
            "off_cont": date/null,
            "cont_hv": date/null,
            "load_test": date/null,
            "rmvu": date/null,
            "panto": date/null,
            "pcp_clear": date/null,
            "bu_form": date/null,
            "rake_form": date/null,
            "remarks": string/null,
            "coach_num": string,
            "rake_num": string
        },
    ],
    "status": 200
    }
### POST /api/position/new
> This route is used both for adding a new status and editing an existing status

> `coach_num` is required. Out of the other 3 parameters, at least one parameter must be sent in the request.

#### Parameters
    {
    "token": string,
    "coach_num": string,
    "linename": string,
    "lineno": integer,
    "stage": integer
    }
#### Response
    {
    "data": {
        "message": string
    },
    "status": 200
    }
### POST /api/position/getall
> Considering only two positions
  #### Parameters
     {
     "token": string,
     }
  #### Response
      {
    "data": [
        {
            "linename": string,
            "stage": integer/null,
            "lineno": integer/null,
            "coach_num": string,
            "rake_num": string
        },
        {
            "linename": string,
            "stage": integer/null,
            "lineno": integer/null,
            "coach_num": string,
            "rake_num": string
        },
    ],
    "status": 200
    }
### POST /api/position/getcoaches
> Considering only two positions

> `linename` is required

> `lineno` and `stage` are optional
  #### Parameters
     {
     "token": string,
     "linename": string,
     "lineno": integer,
     "stage": integer
     }
  #### Response
      {
    "data": [
        {
            "linename": string,
            "stage": integer/null,
            "lineno": integer/null,
            "coach_num": string,
            "rake_num": string
        },
        {
            "linename": string,
            "stage": integer/null,
            "lineno": integer/null,
            "coach_num": string,
            "rake_num": string
        },
    ],
    "status": 200
    }