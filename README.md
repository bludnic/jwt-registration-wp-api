```javascript
let params = {
  username: 'vasya', // required
  password: 'elipili', // required
  email: 'vasya.pupkin@example.com', // required
  first_name: 'Vasya Pupkin',
  last_name: ''
};

this.http.post('http://example.com/wp-json/jwt-auth/v1/token', params)
.map(res => res.json())
.subscribe((user) => {
  console.log(user.token); // Will be used for JWT Authentication 
}, (err) => {
  console.error(err.message);
});
```
Requires JWT Authentication Plugin https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/
