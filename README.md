# Laravel REST API

## Instalação

```bash
# 1. Subir containers Docker
docker-compose up -d

# 2. Instalar dependências
docker-compose exec app composer install

# 3. Copiar arquivo de ambiente
cp .env.example .env

# 4. Gerar chaves
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan jwt:secret

# 5. Rodar migrations
docker-compose exec app php artisan migrate

# 6. Verificar se está funcionando
curl http://localhost:8000/api/health
```

## Acessar

- **API**: http://localhost:8000/api

## Postman Collection

Na pasta `postman/` existe uma collection do Postman com todas as rotas da API. Para utilizá-la:

1. Abra o Postman
2. Importe o arquivo `postman/postman_collection.json`
3. Todas as rotas estarão disponíveis para teste

## Principais Endpoints

```bash
# Autenticação
POST /api/auth/register    # Criar conta
POST /api/auth/login       # Login
POST /api/auth/logout      # Logout (requer token)
GET  /api/auth/me          # Usuário autenticado (requer token)

# Usuários (requer token)
GET    /api/users          # Listar
POST   /api/users          # Criar
GET    /api/users/{id}     # Ver
PUT    /api/users/{id}     # Atualizar
DELETE /api/users/{id}     # Deletar (soft delete)

# Endereços (requer token)
GET    /api/addresses              # Listar
POST   /api/addresses              # Criar
GET    /api/addresses/{id}         # Ver
PUT    /api/addresses/{id}         # Atualizar
DELETE /api/addresses/{id}         # Deletar
GET    /api/addresses/user/{id}    # Ver endereços do usuário

# Permissões (requer token)
GET    /api/permissions                          # Listar
POST   /api/permissions                          # Criar
GET    /api/permissions/{id}                     # Ver
PUT    /api/permissions/{id}                     # Atualizar
DELETE /api/permissions/{id}                     # Deletar
GET    /api/users/{id}/permissions               # Ver permissões do usuário
POST   /api/users/{id}/permissions               # Atribuir permissão
DELETE /api/users/{id}/permissions/{permId}      # Revogar permissão
```

## Comandos Úteis

```bash
# Rodar testes
docker-compose exec app php artisan test

# Limpar cache
docker-compose exec app php artisan config:clear

# Ver rotas
docker-compose exec app php artisan route:list

# Entrar no container
docker-compose exec app bash
```


In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
