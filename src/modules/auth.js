import http from './http';

export function login(userid, password) {
    return http.post('/login', {
        userid,
        password
    });

}
