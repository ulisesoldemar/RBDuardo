var conn = new WebSocket('ws://localhost:8080');

conn.onopen = function (e) {
    console.log("Connection established!");
};

conn.onmessage = function (e) {
    console.log(e.data);
};


function handleCommands(userId_p, channel_p, message_p, from_p, to_p) {
    register = function (e) {
        conn.send(JSON.stringify({
            command: "register",
            userId: userId_p
        }));
    }
    subscribe = function (e) {
        conn.send(JSON.stringify({
            command: 'subscribe',
            channel: channel_p
        }));
    }
    message = function (e) {
        conn.send(JSON.stringify({
            command: 'message',
            from: from_p,
            to: to_p,
            message: message_p
        }));
    }
    groupchat = function (e) {
        conn.send(JSON.stringify({
            command: 'groupchat',
            message: message_p
        }));
    }
}

