# 🔐 Token Configuration Guide

## Token Expiration Settings

Your Sanctum tokens are now configured to last for **1 year** before expiring.

### Configuration Files Updated

1. **`config/sanctum.php`**
   - Set `'expiration' => 525600` (1 year in minutes)

2. **`app/Http/Controllers/AuthController.php`**
   - Updated `register()` method to set explicit token expiration
   - Updated `login()` method to set explicit token expiration
   - Tokens now include: `->createToken('auth-token', ['*'], now()->addYear())`

### How It Works

When a user logs in or registers, they receive a token that:
- ✅ Remains valid for 1 year
- ✅ Is stored in localStorage on the frontend
- ✅ Is automatically included in all API requests
- ✅ Can be manually revoked via logout

### Token Expiration Options

You can customize the expiration time in `config/sanctum.php`:

```php
// No expiration (not recommended for production)
'expiration' => null,

// 1 day
'expiration' => 1440,

// 1 week
'expiration' => 10080,

// 1 month (30 days)
'expiration' => 43200,

// 1 year (365 days) - Current setting
'expiration' => 525600,
```

### Or Set Per-Token Expiration

In the AuthController, you can set different expiration times:

```php
// 30 days
$token = $user->createToken('auth-token', ['*'], now()->addDays(30))->plainTextToken;

// 6 months
$token = $user->createToken('auth-token', ['*'], now()->addMonths(6))->plainTextToken;

// 1 year (current setting)
$token = $user->createToken('auth-token', ['*'], now()->addYear())->plainTextToken;

// Never expires (use config setting)
$token = $user->createToken('auth-token')->plainTextToken;
```

### Testing Token Expiration

To test if tokens are working correctly:

1. Login and get a token
2. Wait a few minutes
3. Try to access `/api/tasks` with the token
4. If it works, your token is still valid!

### Manual Token Revocation

Tokens are automatically deleted when a user:
- Logs out (via `/api/logout`)
- Logs in again (old tokens are deleted)

### Database Storage

Tokens are stored in the `personal_access_tokens` table with an `expires_at` column that shows when each token will expire.

You can check token expiration in the database:

```sql
SELECT name, expires_at, created_at 
FROM personal_access_tokens 
WHERE tokenable_id = USER_ID;
```

### Production Recommendations

For production environments:
- ✅ Use shorter expiration times (7-30 days)
- ✅ Implement token refresh mechanism
- ✅ Monitor token usage
- ✅ Implement rate limiting
- ✅ Use HTTPS only
- ✅ Rotate tokens periodically

### Troubleshooting

**Problem:** Tokens still expiring quickly
**Solutions:**
1. Run `php artisan config:clear` to clear cached config
2. Check `.env` file for any `SANCTUM_EXPIRATION` override
3. Verify database `personal_access_tokens.expires_at` column
4. Check if session is expiring (shouldn't affect API tokens)

**Problem:** "Unauthenticated" errors
**Solutions:**
1. Check if token is being sent in Authorization header
2. Verify token format: `Bearer YOUR_TOKEN_HERE`
3. Check if token exists in database
4. Verify token hasn't been manually deleted

---

**Your tokens are now configured to last 1 year! 🎉**
