# ICF Chennai

## Route Documentation
- Adjust the base url of the JSON API requests to the url where the website is hosted.
- Every response is a JSON object with either of the two keys `data` and `errors` and a `status` key.
- Every `errors` key is an object consisting of multiple errors with each error having a `title` key.
- `status` key has `200` for a successful request, `400` for a bad request, `401` for an unauthorized request and `500` for an internal server error.

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
