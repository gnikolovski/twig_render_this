# Twig Render This

Let's look at the following two lines:

```
{{ content.field_tags }}
{{ node.field_tags }}
```

The difference between these two lines is that in the first case we have the 
Tags field as a rendered array, and in the second case we have this field as an
object.

You can use the first line in your template to print out the Tags field. But in
some cases you might want to print out a field from the node directly. If you 
put the second line in your node template, you will get an error:

```
Object of type Drupal\Core\Field\EntityReferenceFieldItemList cannot be printed
```

You cannot print an object just like that. You can if you call the view() method
on that object:

```
{{ node.field_tags.view() }}
```

But this is not allowed by default. Drupal 8 comes with the Twig Sandbox Policy
and by default the view() method is blacklisted. In order to whitelist this
method you must edit your settings.php file and add the following lines:

```
$settings['twig_sandbox_whitelisted_methods'] = [
  'id',
  'label',
  'bundle',
  'get',
  '__toString',
  'toString',
  'referencedEntities',
  'view',
];
```

If you don't want to whitelist any method that is by default blacklisted, or if
editing the settings.php file is not an option, and you want to print field in a
template you need another solution.

You can use the "Twig Render This" module which provides a simple Twig filter. 
After you install this module you can use the following syntax in your template:

```
{{ node.field_tags | renderThis }}
```

If you want to use a specific display mode you can use the following syntax:

```
{{ node.field_tags | renderThis('teaser') }}
```

If you do not provide the display mode, this filter will use the default mode.

This filter can be especially useful in your Views templates. For example you
might be listing node teasers in a View, and then you can use the following
code to print out View fields:

```
{% for row in rows %}
  {{ row.content['#node'].field_svg | renderThis }}
{% endfor %}
```

### AUTHOR

Goran Nikolovski  
Website: http://gorannikolovski.com  
Drupal: https://www.drupal.org/user/3451979  
Email: nikolovski84@gmail.com  

Company: Studio Present, Subotica, Serbia  
Website: http://www.studiopresent.com  
Drupal: https://www.drupal.org/studio-present  
Email: info@studiopresent.com  
