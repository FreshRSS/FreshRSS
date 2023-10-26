{{/*
Generate a name based on the release name and chart name.
*/}}
{{- define "name" -}}
{{- default .Chart.Name .Release.Name -}}
{{- end -}}

