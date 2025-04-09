## Validations

Laravel Log Validator enforces several validation rules to ensure consistent and maintainable logs across your application:

### Message Validation

1. **Maximum Length**: Log messages must not exceed 50 characters
2. **Format**: Messages must start with a capital letter
3. **Character Set**: Only alphanumeric characters, spaces, and basic punctuation (.-_:) are allowed

**Examples:**
```php
// ✅ Valid
Log::info('User registered successfully');
Log::error('Payment processing failed');

// ❌ Invalid
Log::info('user registered successfully');  // Doesn't start with capital
Log::error('The payment processing failed with error code 500 and we need to investigate this issue further');  // Too long
Log::warning('User signed-in from suspicious IP!');  // Contains invalid character (!)
```

### Context Validation

1. **Maximum Fields**: Context arrays must contain no more than 10 fields
2. **Key Format**: All context keys must use camelCase format (e.g., `userId` not `user_id`)
3. **Value Types**: Context values must be scalar types (string, int, float, bool, null) or arrays of scalar types
4. **No Complex Data**: Objects, resources, closures, and nested arrays are not allowed in context

```php
// ✅ Valid
Log::info('User registered', ['userId' => 123, 'emailVerified' => true]);
Log::error('Payment failed', ['orderId' => 'ORD-123', 'errorCodes' => [4001, 4002]]);

// ❌ Invalid
Log::info('User registered', ['user_id' => 123]);  // Not camelCase
Log::error('Payment failed', ['order' => new Order()]);  // Contains object
Log::warning('Data processed', ['items' => [['id' => 1], ['id' => 2]]]);  // Nested array
```

### Exception Handling

Logs containing an exception in their context are exempted from validation. This allows for detailed exception logging without validation constraints.

### Environment Configuration

By default, validations only run in non-production environments (`local`, `testing`, `staging`). You can customize this in the `laravel-log-validator.php` config file.
