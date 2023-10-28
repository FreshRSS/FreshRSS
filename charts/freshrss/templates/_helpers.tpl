{{/*
Generate a name based on the release name and chart name.
*/}}
{{- define "name" -}}
{{- default .Chart.Name .Release.Name -}}
{{- end -}}

# Data PVC name.
{{- define "freshrss.dataPVC" -}}
{{- if .Values.persistence.existingPVCName }}
{{- .Values.persistence.existingPVCName }}
{{- else }}
{{- .Release.Name }}-data
{{- end }}
{{- end }}


# Listen Port
{{- define "freshrss.port" -}}
{{- if .Values.freshrss.LISTEN }}
{{- .Values.freshrss.LISTEN }}
{{- else }}
80
{{- end }}
{{- end }}