```toml
name = 'Authenticated'
sortWeight = 1000000
id = '30a30497-f1d6-4af4-b0be-26e85a35ec2f'

[[headers]]
key = 'Authorization'
value = '{{auth.access_token}}'

[[headers]]
key = 'Content-Type'
value = 'application/json'

[[headers]]
key = 'Accept'
value = 'application/json'
```

#### Variables

```json5
{
  "host": "https://lk.nngasu.ru",
  "auth": {
    "access_token": null,
  }
}
```
