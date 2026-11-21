```toml
name = 'Application'
description = 'Main Application API'
sortWeight = 2000000
id = '74354c4e-0c24-46dd-93da-c526cea08c4f'

[[headers]]
key = 'Accept'
value = 'application/json'

[auth.bearer]
token = '{{auth.access_token}}'
```

#### Variables

```json5
{
  host: "{{host}}/api",
  auth: {
    access_token: ""
  }
}
```
