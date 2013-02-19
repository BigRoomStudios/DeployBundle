git based deployment for BRS symfony projects

configuration example:

    parameters:
        deploy_targets:
            prod:
                ssh: deploy@bigroomstudios.com
                app: /home/bigroomstudios/domains/bigroomstudios.com
            staging:
                ssh: deploy@bigroomstudios.com
                app: /home/bigroomstudios/domains/staging.bigroomstudios.com


In this example, the target location has a user named "deploy" - you would grant access to the deploy user by adding the local user's public key to deploy's .ssh/authorized_keys file.  The deploy user would have proper filesystem access to the app location.  You would configure ssh access to the remote machine using your local .ssh/config file.

It assumes that the app locations are already checked out and working copies of the repo.  This is more or less what happens:

  * pulls the shell from the master branch
  * installs any new src bundles
  * clears the dev cache
  * installs any new assets
  * updates all existing src bundles
  * updates the schema
  * updates production assets
  * clears the production cache

Todo:

  * add option to create a new git tag as a reference
  * add ability to deploy by tag name
  * add ability to deploy to multiple servers
  * revert a target to the last used tag


