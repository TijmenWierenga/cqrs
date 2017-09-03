#!/usr/bin/env groovy

pipeline {
    agent any

    stages {
        stage('build') {
            steps {
                sh "make build"
            }
        }

        stage('test') {
            steps {
                sh "make test"
            }
        }

        stage('teardown') {
            steps {
                sh "make teardown"
            }
        }
    }
}
