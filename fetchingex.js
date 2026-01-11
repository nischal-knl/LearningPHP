
fetch('api/users.php')
    .then(response => response.json())
    .then(data => {
        console.log("User List:", data);
        
    })
    .catch(error => console.error('Error:', error));


const newUser = {
    username: "nischal",
    dob: "2003-06-05",
    email: "nischal@example.com",
    password: "secretpassword"
};

fetch('api/users.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(newUser)
})
.then(res => res.json())
.then(response => alert(response.message));