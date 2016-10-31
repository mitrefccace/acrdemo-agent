
# ASERVER
#### This is the README file for the FCC Task 3 RESTful Server for accessing the agent database.

The ASERVER currently runs on port 8084 (see app.js).

## Installation Instructions
### Configure corporate proxy server
1. npm config set proxy _HTTP-PROXY-URL_
1. npm config set https-proxy _HTTPS-PROXY-URL_

#### Installing Node.js
1. On Windows... https://nodejs.org/en/
1. on Linux...
    1. sudo apt-get update
	1. sudo apt-get install nodejs
  1. sudo ln -s /usr/bin/nodejs /usr/bin/node
	1. sudo apt-get install npm
1. Clone this repo
1. From the command line...
    1. cd aserver
    2. npm init
    3. npm install express --save
    4. npm install body-parser --save
    5. npm install mysql --save
    6. npm install clear --save
    7. npm install --save
    8. node app.js

#### Running the Server in AWS
Usage:  
nodejs app.js [ port ]

#### Testing the Server in AWS
* curl --request GET http://localhost:8084
* curl --request GET http://localhost:8084/agentverify/?username=dbuser&password=dbpassword
* curl --request GET http://localhost:8084/getallagentrecs

# SERVICE API

----

#agentverify

  _Verify an agent ID and password._

* **URL**

  _/agentverify/?username=dbuser&password=dbpassword_

* **Method:**

   `GET`

*  **URL Params**

   **Required:**

   `username=[string]`
   `password=[string]`

   **Optional:**

   _None._

* **Data Params**

  _None._

* **Success Response:**

  * **Code:** 200, **Content:** `{
  "message": "success",
  "data": [
    {
      "agent_id": 1,
      "username": "user1",
      "first_name": "Ed",
      "last_name": "Jones",
      "role": "manager",
      "phone": "222-000-0000",
      "email": "ed@portal.com",
      "organization": "Organization Bravo",
      "extension": 4001,
      "extension_secret": "password1",
      "queue_name": "GeneralQuestionsQueue",
      "soft_extension": 6000,
      "soft_queue_name": "ComplaintsQueue"    
    }
  ]
}

* **Error Response:**
  * **Code:** 400 BAD REQUEST, **Content:** `{'message': 'missing username'}`
  * **Code:** 400 BAD REQUEST, **Content:** `{'message': 'missing password'}`
  * **Code:** 404 NOT FOUND, **Content:** `{'message': 'username number not found'}`
  * **Code:** 500 INTERNAL SERVER ERROR, **Content:** `{'message': 'mysql error'}`
  * **Code:** 501 NOT IMPLEMENTED, **Content:** `{'message': 'records returned is not 1'}`

* **Sample Call:**

  http://localhost:8083/agentverify/?username=dbuser&password=dbpassword

* **Notes:**

  _None._

----
#getallagentrecs

  _Get all the agent records in the agent database._

* **URL**

  _/getallagentrecs_

* **Method:**

   `GET`

*  **URL Params**

   **Required:**

   _None._

   **Optional:**

   _None._

* **Data Params**

  _None._

* **Success Response:**

  * **Code:** 200, **Content:** `{
  	"message": "success",
  	"data": [{
  		"agent_id": 0,
  		"username": "admin",
  		"first_name": "Kevin",
  		"last_name": "Spacey",
  		"role": "administrator",
  		"phone": "000-000-0000",
  		"email": "admin@portal.com",
  		"organization": "Organization Alpha",
  		"is_approved": 1,
  		"is_active": 1,
  		"extension": 5010,
  		"extension_secret": "password1",
  		"queue_name": "ComplaintsQueue",
  		"soft_extension": 6000,
  		"soft_queue_name": "ComplaintsQueue"
  	}, {
  		"agent_id": 1,
  		"username": "root",
  		"first_name": "Ed",
  		"last_name": "Jones",
  		"role": "manager",
  		"phone": "222-000-0000",
  		"email": "ed@portal.com",
  		"organization": "Organization Bravo",
  		"is_approved": 1,
  		"is_active": 1,
  		"extension": 5011,
  		"extension_secret": "password1",
  		"queue_name": "GeneralQuestionsQueue",
  		"soft_extension": 6000,
  		"soft_queue_name": "ComplaintsQueue"
  	}, {
  		"agent_id": 28,
  		"username": "user3",
  		"first_name": "Jim",
  		"last_name": "Smith",
  		"role": "agent",
  		"phone": "",
  		"email": "jsmith123@company.com",
  		"organization": "My Organization",
  		"is_approved": 0,
  		"is_active": 1,
  		"extension": 9012,
  		"extension_secret": "password1",
  		"queue_name": "Queue1010",
  		"soft_extension": 6000,
  		"soft_queue_name": "ComplaintsQueue"
  	}]
  }`

* **Error Response:**
  * **Code:** 204 NO CONTENT, **Content:** `{'message': 'agent_id number not found'}`
  * **Code:** 400 BAD REQUEST, **Content:** `{'message': 'missing agent_id'}`
  * **Code:** 400 BAD REQUEST, **Content:** `{'message': 'missing password'}`
  * **Code:** 404 NOT FOUND, **Content:** `{'message': 'agent_id not found'}`
  * **Code:** 500 INTERNAL SERVER ERROR, **Content:** `{'message': 'mysql error'}`
  * **Code:** 501 INTERNAL SERVER ERROR, **Content:** `{'message': 'records returned is not 1'}`


* **Sample Call:**

  http://localhost:8083/getallagentrecs

* **Notes:**

  _None._

----

##Test Service

_This is just a test service to quickly check the connection._

* **URL**

  _/_

* **Method:**

  `GET`

*  **URL Params**

   _None._

   **Required:**

   _None._

   **Optional:**

   _None._

* **Data Params**

  _None._

* **Success Response:**
  * **Code:** 200
  * **Content:** `{ "message": "Hello world from the updated agent portal." }`

* **Error Response:**

  _None._

* **Sample Call:**

  http://localhost:8083/

* **Notes:**

  _None._

----

#getscript

  _Get a script for a particular type of complaint for a complaint queue._

* **URL**

  _/getscript/?type=GeneralComplaint&queue_name=ZVRSComplaintsQueue_

* **Method:**

   `GET`

*  **URL Params**

   **Required:**

   `type=[string]`
   `queue_name=[string]`

   **Optional:**

   _None._

* **Data Params**

  _None._

* **Success Response:**

  * **Code:** 200, **Content:** `{"message":"success","data":[{"id":1,"type":"GeneralComplaint","text":"Hello [CUSTOMER NAME], this is [AGENT NAME] calling from Agent Portal Services. Have I caught you in the middle of anything? The purpose for my call is to help improve our service to customers. I do not know the nature of your complaint, and this is why I have a couple of questions. How do you feel about our service? When was the last time you used our service? Well, based on your answers, it sounds like we can learn a lot from you if we were to talk in more detail. Are you available to put a brief 15 to 20 minute meeting on the calendar where we can discuss this in more detail and share any insight and value you may have to offer?","queue_name":"ZVRSComplaintsQueue","date":"2016-04-01T00:00:00.000Z"}]}`

* **Error Response:**
  * **Code:** 400 BAD REQUEST, **Content:** `{'message': 'missing type field'}`
  * **Code:** 400 BAD REQUEST, **Content:** `{'message': 'missing queue_name field'}`
  * **Code:** 404 NOT FOUND, **Content:** `{'message': 'script not found'}`
  * **Code:** 500 INTERNAL SERVER ERROR, **Content:** `{'message': 'mysql error'}`
  * **Code:** 501 NOT IMPLEMENTED, **Content:** `{'message': 'records returned is not 1'}`

* **Sample Call:**

  http://localhost:8083/getscript/?type=GeneralComplaint&queue_name=ZVRSComplaintsQueue

* **Notes:**

  _None._
