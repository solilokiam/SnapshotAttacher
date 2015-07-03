# README


## What is Snapshoter?
Snapshoter is a tool to create and attach EBS tagged snapshots to EC2 instances. 
It's meant to be used in autoscalling processes.

##Installation

Download the Snapshoter.phar file from:

http://solilokiam.github.io/SnapshoterDist/downloads/Snapshoter-0.1.4.phar

And add a config.yml file with the following:

```yml
snapshoter:
    aws:
        key: 12345 #your aws key
        secret: 12345 #your aws secret
        region: eu-west-1 #the region in which you want to create snapshots
```

##Usage
There ase the following commands available:

###create
Create command is used to create a snapshot with the selected tag.

```
Snapshoter.phar create [options] [--] <snapshot_tag>
```
####Arguments
snapshot_tag: The name of the tag that will have the snapshot

####Options
This command supports the following options:
* `-m`, `--device=DEVICE`: The mount point of the volume to create the snapshot. If none specified it will use /dev/sdf
* `-i`, `--instance_id=INSTANCE_ID`: The instance id in which the volume to create the snapshot is attached, if not defined it will try to do it in the current machine
* `-d`, `--description=DESCRIPTION`: The description of the snapshot. If none specified it will use "Snapshot created automatically by snapshoter"

###attach
The Attach command is used to create a volume from the selected snapshot and then attach it to the selected instance. If the specified tag contains more than one snapshot it will use the newest one.

```
Snapshoter.phar attach [options] [--] <snapshot_tag>
```

####Arguments
snapshot_tag: The name of the snapshot tag that has to be used to create and attach the volume

####Options
This command supports the following options:
* `-m`, `--device_key=DEVICE_KEY`: The desired mount point as defined by aws. By default: "/dev/sdf"
* `-s`, `--volume_size=VOLUME_SIZE`: The desired initial volume size by default it will be snapshot size
* `-z`, `--availability_zone=AVAILABILITY_ZONE`: The availability_zone in which to create the volume. By default: "eu-west-1b"
* `--instance_id=INSTANCE_ID`: The instance id to attach the new volume, if not defined it will try to do it in the current machine
* `--delete_on_termination`: The created volume will be deleted on instance termination
* `--device_value`: The desired mount point as defined by your os.  For example ubuntu turns /dev/sdf to /dev/xvdf. By default: /dev/xvdf

###instanceid
This commands return the instanceid of the EC2 instance that has snapshoter installed

```
Snapshoter.phar instanceid
```

###delete
The delete command is used to delete the all snapshots created with a given tag or delete only one snapshot with the specified id.
```
Snapshoter.phar delete [options] [--] [<snapshot_tag>]
```

####Arguments
snapshot_tag: The name of the snapshot tag that will be used to delete the snapshots

####Options
This command supports the following options:
* `-i`, `--snapshotId=SNAPSHOT_ID`: The id of the snapshot to delete if no tag has been specified
* `-p`, '--pardon=PARDON': The number of snapshots to pardon. The n last snapshots will not be deleted

###update
This command self-updates the snapshoter.phar to the latest version

##Stability
Although this script is being used in production actively. This piece of software is in beta state.

##Contribute
You can contribute in one of three ways:

1. File bug reports using the issue tracker.
2. Answer questions or fix bugs on the issue tracker.
3. Contribute new features by forking and Pull requesting

##Developing tips
If you want to develop and create your won phar file you will need to install [box-project!](https://github.com/box-project/box2) and run `box build`

> The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable.




