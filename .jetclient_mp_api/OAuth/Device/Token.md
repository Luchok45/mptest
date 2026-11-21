```toml
name = 'Token'
method = 'POST'
url = '{{host}}/oauth/token'
sortWeight = 2000000
id = '61d691d7-5c00-499a-a0d1-ca2fe33ff395'

[[body.formData]]
key = 'grant_type'
value = 'urn:ietf:params:oauth:grant-type:device_code'

[[body.formData]]
key = 'client_id'
value = '{{client_id}}'

[[body.formData]]
key = 'client_secret'
value = '{{client_secret}}'

[[body.formData]]
key = 'device_code'
value = '{{device_code}}'
```
