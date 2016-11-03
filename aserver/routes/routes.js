// Define the different REST service routes in this file.

var appRouter = function(app,connection) {

    //AGENTVERIFY
    //GET request; e.g. http://localhost:8084/agentverify/?username=admin&password=admin
    app.get('/agentverify', function(req, res) {
        if (!req.query.username) {
          return res.status(400).send({'message': 'missing username'});
        }
        else if (!req.query.password) {
          return res.status(400).send({'message': 'missing password'});
        }
        else {
            //Query DB for agent info
            connection.query('SELECT ad.agent_id, ad.username, ad.first_name, ad.last_name, ad.role, ad.phone, ad.email, ad.organization, ad.is_approved, ad.is_active, ae.extension, ae.extension_secret, aq.queue_name, aq2.queue_name AS queue2_name, oc.channel FROM agent_data AS ad LEFT JOIN asterisk_extensions AS ae ON ad.agent_id = ae.id LEFT JOIN asterisk_queues AS aq ON aq.id = ad.queue_id LEFT JOIN asterisk_queues AS aq2 ON aq2.id = ad.queue2_id LEFT JOIN outgoing_channels AS oc ON oc.id = ae.id WHERE ad.username = ? AND ad.password = ?',[req.query.username , req.query.password], function(err, rows, fields) {
                if (err) {
                    console.log(err);
                    return res.status(500).send({'message': 'mysql error'});
                } 
                else if (rows.length === 1) {
                    //success
                    json = JSON.stringify(rows);
                    res.status(200).send({'message': 'success', 'data':rows});
                } 
                else if (rows.length === 0) {
                    return res.status(404).send({'message': 'username not found'});
                } else {
                    console.log('error - records returned is ' + rows.length);
                    return res.status(501).send({'message': 'records returned is not 1'});
                }
            });
        }
  });


    //GETALLAGENTRECS
    //GET request; e.g. http://localhost:8084/getallagentrecs
    app.get('/getallagentrecs', function(req, res) {
        //Query DB for all agent records
        connection.query('SELECT ad.agent_id, ad.username, ad.first_name, ad.last_name, ad.role, ad.phone, ad.email, ad.organization, ad.is_approved, ad.is_active, ae.extension, ae.extension_secret, aq.queue_name, aq2.queue_name AS queue2_name, oc.channel FROM agent_data AS ad LEFT JOIN asterisk_extensions AS ae ON ad.agent_id = ae.id LEFT JOIN asterisk_queues AS aq ON aq.id = ad.queue_id LEFT JOIN asterisk_queues AS aq2 ON aq2.id = ad.queue2_id LEFT JOIN outgoing_channels AS oc ON oc.id = ae.id ORDER BY agent_id', function(err, rows, fields) {
            if (err) {
                console.log(err);
            return res.status(500).send({'message': 'mysql error'});
            } 
            else if (rows.length > 0) {
                //success
                json = JSON.stringify(rows);
                res.status(200).send({'message': 'success', 'data':rows});
            } 
            else if (rows.length === 0) {
                return res.status(204).send({'message': 'no agent records'});
            }
        });
    });

    //GETSCRIPT
    //GET request; e.g. http://localhost:8084/getscript/?queue_name=ZVRSComplaintsQueue&type=GeneralComplaint
    app.get('/getscript', function(req, res) {
        if (!req.query.queue_name) {
            return res.status(400).send({'message': 'missing queue_name field'});
        }
        else {
            //Query DB for script info
            connection.query('SELECT s.id, aq.queue_name, s.text, s.date FROM scripts AS s, asterisk_queues AS aq WHERE s.queue_id = aq.id AND aq.queue_name = ?',[req.query.queue_name], function(err, rows, fields) {
                if (err) {
                    console.log(err);
                    return res.status(500).send({'message': 'mysql error'});
                } 
                else if (rows.length === 1) {
                    //success
                    json = JSON.stringify(rows);
                    res.status(200).send({'message': 'success', 'data':rows});
                } 
                else if (rows.length === 0) {
                    return res.status(404).send({'message': 'script not found'});
                } 
                else {
                    console.log('error - records returned is ' + rows.length);
                    return res.status(501).send({'message': 'records returned is not 1'});
                }
            });
        }
    });
  
  //GETALLSCRIPTS
  //GET request; e.g. http://localhost:8084/getallscripts
  app.get('/getallscripts', function(req, res) { 

        //Query DB for script info
        connection.query('SELECT s.id, aq.queue_name, s.text, s.date FROM scripts AS s, asterisk_queues AS aq WHERE s.queue_id = aq.id', function(err, rows, fields) {
            if (err) {
                console.log(err);
                return res.status(500).send({'message': 'mysql error'});
            } 
            else if (rows.length >= 1) {
                //success
                json = JSON.stringify(rows);
                res.status(200).send({'message': 'success', 'data':rows});
            } 
            else if (rows.length === 0) {
                return res.status(404).send({'message': 'script not found'});
            } 
      });
  });


  // This is just for testing the connection
  // GET request; e.g. http://localhost:8084/
  app.get('/', function(req, res) {
    return res.status(200).send({'message': 'Welcome to the agent portal.'});
  });

};

module.exports = appRouter;
