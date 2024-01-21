const pwdMismatch = document.getElementById("userPwd");//gets the html element with the id 'userPwd'
const password = document.getElementById("password");//gets the html element with the id 'password'
const confirmPassword = document.getElementById("confirmPassword");//gets the html element with the id 'confirmPassword'

const userMismatch = document.getElementById("userMismatch");//gets the html element with the id 'userMismatch'
const username = document.getElementById("username");//gets the html element with the id 'username'
const confirmUsername = document.getElementById("confirmUsername");//gets the html element with the id 'confirmUsername'

/**
 * Compares the password and confirm password to see if they match
 */
function validatePwd() {
    if (password.value !== confirmPassword.value){
        pwdMismatch.innerHTML = '<small class="text-danger">The passwords do not match</small>';//Both ids are not equal
    } else {
        pwdMismatch.innerHTML = '<small style="color: #4CAF50"> The passwords match</small>';//Both ids are equal
    }
}

/**
 * Compares the username and confirm username to see if they match
 */
function validateName() {
    if (username.value !== confirmUsername.value){
        userMismatch.innerHTML = '<small class="text-danger">The usernames do not match</small>';//Both ids are not equal
    } else {
        userMismatch.innerHTML = '<small style="color: #4CAF50"> The usernames match</small>';//Both ids are equal
    }
}