// Twilio Credentials 
var accountSid = 'ACbc8c562cb1021b017d9084070c5996c3'; 
var authToken = '88cb261f40a7aad55836c284a7db820a'; 
 
//require the Twilio module and create a REST client 
var client = require('twilio')(accountSid, authToken); 
 
client.messages.create({ 
    to: "+12896813107", 
    from: "+14387950306", 
    body: "Hey Jenny! Good luck on the bar exam!", 
}, function(err, message) { 
    console.log(message.sid); 
});