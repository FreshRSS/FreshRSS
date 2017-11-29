The update process depends on your installation type. 
If you installes FreshRSS using git, then please refer to our [cli documentation](https://github.com/FreshRSS/FreshRSS/tree/dev/cli).

# Using the web admin panel

*TODO*

# Using git

See [cli documentation](https://github.com/FreshRSS/FreshRSS/tree/dev/cli#install-and-updates).

# Using shell

If you installed FreshRSS with the ZIP archive you have to perform a couple more steps:
```
# Perform all commands below in your FreshRSS directory:
cd /usr/share/FreshRSS

# Download the latest version
wget https://github.com/FreshRSS/FreshRSS/archive/master.zip

# And unzip it
unzip master.zip

# Now overwrite all your existig files with the new ones
cp -R FreshRSS-master/* .

# And cleanup
rm -rf FreshRSS-master/
```
