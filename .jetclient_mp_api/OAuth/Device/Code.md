```toml
name = 'Code'
description = 'Request authentication code'
method = 'POST'
url = '{{host}}/oauth/device/code'
sortWeight = 1000000
id = 'b94a2653-254f-40ff-aa58-bff46c486c7a'

[[body.formData]]
key = 'client_id'
value = '{{client_id}}'

[[body.formData]]
key = 'scope'
```
