const express = require('express')
const app = express()
const server = require('http').createServer(app)

const io = require('socket.io')(server,{
    cors: {origin: "*"}
})

/**
 * @var users[]
 * key: user_id
 * value: soket.id
 * ai online thì thêm vào mảng
 * ai offline thì xóa khỏi mảng
 */
var users = []

io.on('connection', (socket) => {
    console.log('Connection')

    socket.on('sendUserOnlineToServer', (user_id) =>{
        users[user_id] = socket.id
        io.emit('sendUserOnlineToClient', user_id)
        console.log('user connected ' + user_id)
    })

    socket.on('sendChatToServer', (data) =>{
        io.sockets.emit('sendChatToClient', data)
    })

    socket.on('sendSeenToServer', (data) =>{
        io.sockets.emit('sendSeenToClient', data)
    })

    socket.on('sendCommentToServer', (data) =>{
        io.sockets.emit('sendCommentToClient', data)
    })

    socket.on('sendReplyToServer', (data) =>{
        io.sockets.emit('sendReplyToClient', data)
    })

    socket.on('sendNotificationToServer', (data) =>{
        io.sockets.emit('sendNotificationToClient', data)
    })

    socket.on('sendNotificationLikeToServer', (data) =>{
        io.sockets.emit('sendNotificationLikeToClient', data)
    })

    socket.on('sendNotificationCommentToServer', (data) =>{
        io.sockets.emit('sendNotificationCommentToClient', data)
    })

    socket.on('sendNotificationReplyToServer', (data) =>{
        io.sockets.emit('sendNotificationReplyToClient', data)
    })

    socket.on('sendNotificationRequestToServer', (data) =>{
        io.sockets.emit('sendNotificationRequestToClient', data)
    })

    socket.on('disconnect', () => {
        var i = users.indexOf(socket.id)
        users.splice(i,1,0)
        io.emit('sendUserOfflineToClient', i)
        console.log('user disconnect ' + i)
    })
})

server.listen(3000, () => {
    console.log('Server 3000 is running');
})