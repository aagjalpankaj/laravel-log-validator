# Usage

### Adding New Logs
When you add a new log that doesn't meet the validation criteria, this package will throw an `UnprocessableLogException`. 
This validation only occurs in non-production environments, and you can configure which environments should have validation enabled via the configuration file.

### Correcting Existing Logs
If you have existing tests, they may fail when existing logs don't meet the validation criteria. You'll need to update these logs to comply with the validation rules.

If you don't have tests, you may notice `UnprocessableLogException` being thrown in your non-production environments. In either case, you'll need to correct the non-compliant logs.

### Get Log Insights
Run the following command to get quick insights about your application's logging patterns:

```bash
php artisan lalo:insights
```
