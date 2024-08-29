<!DOCTYPE html>
<html>
<head>
    <title>Chat Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        #sidebar {
            width: 300px;
            background-color: #fff;
            border-right: 1px solid #ccc;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        #sidebar h3 {
            margin: 0;
            padding: 10px;
            background-color: #0078d4;
            color: #fff;
        }
        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        #sidebar li {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #ccc;
        }
        #sidebar li:hover {
            background-color: #f0f0f0;
        }
        #chat-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }
        #chat-box {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            border-bottom: 1px solid #ccc;
        }
        #chat-box p {
            margin: 0 0 10px;
            padding: 10px;
            background-color: #e9e9e9;
            border-radius: 4px;
        }
        #message-form {
            display: flex;
            padding: 10px;
            background-color: #f9f9f9;
        }
        #message {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
        #send {
            padding: 10px 20px;
            border: 1px solid #0078d4;
            border-radius: 4px;
            background-color: #0078d4;
            color: #fff;
            cursor: pointer;
        }
        #send:hover {
            background-color: #005a9e;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h3>Groups</h3>
        <ul id="groups"></ul>
        <h3>People</h3>
        <ul id="people"></ul>
    </div>
    <div id="chat-area">
        <div id="chat-box"></div>
        <div id="message-form">
            <input type="text" id="message" placeholder="Type a message">
            <button id="send">Send</button>
        </div>
    </div>

    <script>
        let currentGroupId = null;
        let currentPersonId = null;

        document.addEventListener('DOMContentLoaded', function() {
            loadSidebar();
            document.getElementById('send').addEventListener('click', sendMessage);
        });

        function loadSidebar() {
            fetch('chat.php?fetchSidebar=true')
                .then(response => response.json())
                .then(data => {
                    const groupsList = document.getElementById('groups');
                    const peopleList = document.getElementById('people');
                    groupsList.innerHTML = '';
                    peopleList.innerHTML = '';

                    data.groups.forEach(group => {
                        const li = document.createElement('li');
                        li.textContent = group.name;
                        li.dataset.groupId = group.id;
                        li.addEventListener('click', () => {
                            currentGroupId = group.id;
                            currentPersonId = null;
                            loadMessages();
                        });
                        groupsList.appendChild(li);
                    });

                    data.people.forEach(person => {
                        const li = document.createElement('li');
                        li.textContent = person.username;
                        li.dataset.personId = person.id;
                        li.addEventListener('click', () => {
                            currentPersonId = person.id;
                            currentGroupId = null;
                            loadMessages();
                        });
                        peopleList.appendChild(li);
                    });
                });
        }

        function loadMessages() {
            let url = 'chat.php?fetchMessages=true';
            if (currentGroupId) {
                url += '&group_id=' + currentGroupId;
            } else if (currentPersonId) {
                url += '&person_id=' + currentPersonId;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';
                    data.forEach(message => {
                        const p = document.createElement('p');
                        p.textContent = `${message.username}: ${message.message} (${message.timestamp})`;
                        chatBox.appendChild(p);
                    });
                });
        }

        function sendMessage() {
            const message = document.getElementById('message').value;
            if (message.trim() !== '') {
                const formData = new URLSearchParams();
                formData.append('message', message);
                if (currentGroupId) {
                    formData.append('group_id', currentGroupId);
                } else if (currentPersonId) {
                    formData.append('person_id', currentPersonId);
                }

                fetch('chat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById('message').value = '';
                        loadMessages();
                    }
                });
            }
        }

        setInterval(loadMessages, 3000);
    </script>
</body>
</html>


<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "chat_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hash);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
    $stmt->close();
}

// Fetch user groups and people chatted with
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['user_id']) && isset($_GET['fetchSidebar'])) {
    $user_id = $_SESSION['user_id'];
    
    // Fetch groups
    $stmt = $conn->prepare("SELECT groups.id, groups.name FROM groups JOIN group_members ON groups.id = group_members.group_id WHERE group_members.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $groups = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch people chatted
    $stmt = $conn->prepare("SELECT DISTINCT users.id, users.username FROM users JOIN messages ON users.id = messages.user_id WHERE users.id != ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $people = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    echo json_encode(['groups' => $groups, 'people' => $people]);
}

// Fetch messages
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['user_id']) && isset($_GET['fetchMessages'])) {
    $user_id = $_SESSION['user_id'];
    $group_id = $_GET['group_id'];
    $person_id = $_GET['person_id'];

    if ($group_id) {
        $stmt = $conn->prepare("SELECT users.username, messages.message, messages.timestamp FROM messages JOIN users ON messages.user_id = users.id WHERE messages.group_id = ? ORDER BY messages.timestamp");
        $stmt->bind_param("i", $group_id);
    } else {
        $stmt = $conn->prepare("SELECT users.username, messages.message, messages.timestamp FROM messages JOIN users ON messages.user_id = users.id WHERE (messages.user_id = ? AND messages.group_id IS NULL) OR (messages.user_id = ? AND messages.group_id IS NULL) ORDER BY messages.timestamp");
        $stmt->bind_param("ii", $user_id, $person_id);
    }
    
    $stmt->execute();
    $messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($messages);
    $stmt->close();
}

// Send message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && isset($_POST['message'])) {
    $user_id = $_SESSION['user_id'];
    $group_id = $_POST['group_id'];
    $person_id = $_POST['person_id'];
    $message = $_POST['message'];

    if ($group_id) {
        $stmt = $conn->prepare("INSERT INTO messages (user_id, group_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $group_id, $message);
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (user_id, group_id, message) VALUES (?, NULL, ?)");
        $stmt->bind_param("is", $person_id, $message);
    }
    
    $stmt->execute();
    echo json_encode(["status" => "success"]);
    $stmt->close();
}

$conn->close();
?>
