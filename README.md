## Example with Angular 4

```javascript
let params = {
  username: 'vasya', // required
  password: 'elipili', // required
  email: 'vasya.pupkin@example.com', // required
  first_name: 'Vasya',
  last_name: 'Pupkin'
};

this.http.post('http://example.com/wp-json/rjwt/v1/user', params)
.map(res => res.json())
.subscribe((user) => {
  console.log(user.token); // Will be used for JWT Authentication 
}, (err) => {
  console.error(err.message);
});
```
Requires JWT Authentication Plugin https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/
