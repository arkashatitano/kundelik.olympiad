
var socket = io.connect('https://dalagram.com:8008');

socket.on('connecting', function () {
    console.log('Соединение...');
});

socket.on('connect', function () {
    console.log('Соединение установленно!');
});


function sendNodeValue(course_id){
    console.log(course_id);

    socket.emit("read",
        {
            message: 'score',
            type: 'score',
            course_id: course_id,
            user_id: $('#g_user_id').val()
        }
    );
}

