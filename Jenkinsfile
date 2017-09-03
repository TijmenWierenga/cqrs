#!/usr/bin/env groovy

node('master') {
    try {
        stage('build') {
            git url: git@github.com:TijmenWierenga/cqrs.git
            sh "make build"
        }

        stage('test') {
            sh "make test"
        }
    } catch(error) {
        throw error
    } finally {
        sh "make teardown"
    }
}
