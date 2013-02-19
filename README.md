git based deployment for BRS symfony projects

usage:

deploys to the "prod" environment of the current app:

    app/console deploy

deploys to the production site and updates the prod cache:

    app/console deploy prod

configuration example:

    parameters:
        deploy_targets:
            prod:
                ssh: deploy@bigroomstudios.com
                app: /home/bigroomstudios/domains/bigroomstudios.com
            staging:
                ssh: deploy@bigroomstudios.com
                app: /home/bigroomstudios/domains/staging.bigroomstudios.com


In this example, the target location has a user named "deploy" who:
  * has the local user's public key installed in it's .ssh/authorized_keys file
  * has proper filesystem access to the app location
  * has pull access to all re remote repos
  
You would configure ssh port on the remote machine using your local .ssh/config file.

It assumes that the app locations are already checked out and working copies of the repo. 

It basically has two modes: deploy to self - or - ssh to a server and remotely run the deploy to self routine.

This is more or less what happens:
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


